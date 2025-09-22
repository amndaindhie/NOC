<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\EmailVerificationOtp;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class EmailVerificationController extends Controller
{
    public function showVerificationForm()
    {
        return view('auth.verify-email-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'email' => 'required|email'
        ]);

        Log::info('Verifying OTP', ['otp' => $request->otp, 'email' => $request->email, 'request_data' => $request->all()]);

        try {
            Log::info('Checking verification record', ['email' => $request->email]);

            // Cari OTP berdasarkan email + kode OTP
            $verification = EmailVerification::where('email', $request->email)
                ->where('otp', $request->otp)
                ->where('is_used', false)
                ->first();

            if (!$verification) {
                // OTP tidak ditemukan / salah
                $message = 'Kode OTP tidak valid.';
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => $message], 422);
                }
                return back()->withErrors(['otp' => $message])->withInput();
            }

            // OTP ketemu, tapi sudah kadaluarsa
            if ($verification->expires_at <= now()) {
                $message = 'Kode OTP sudah kadaluarsa.';
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => $message], 422);
                }
                return back()->withErrors(['otp' => $message])->withInput();
            }


            Log::info('OTP verification found', ['verification_id' => $verification->id, 'registration_id' => $verification->registration_id]);

            // Get registration data from cache
            $registrationData = Cache::get('registration_' . $verification->registration_id);

            if (!$registrationData) {
                Log::warning('Registration data not found in cache', ['registration_id' => $verification->registration_id]);

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data registrasi sudah kadaluarsa. Silakan daftar ulang.'
                    ], 422);
                }

                return back()->withErrors(['otp' => 'Data registrasi sudah kadaluarsa. Silakan daftar ulang.'])->withInput();
            }

            Log::info('Registration data found in cache', ['email' => $registrationData['email']]);

            // Create user after verification
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'password' => $registrationData['password'],
                'email_verified_at' => now(),
            ]);

            // Assign default 'user' role to new user
            $user->assignRole('user');

            Log::info('User created successfully', ['user_id' => $user->id, 'email' => $user->email]);

            // Mark OTP as used
            $verification->update(['is_used' => true]);
            Log::info('OTP marked as used', ['verification_id' => $verification->id]);

            // Clear cache
            Cache::forget('registration_' . $verification->registration_id);
            Log::info('Cache cleared for registration', ['registration_id' => $verification->registration_id]);

            // Auto login after successful verification
            Auth::login($user);
            Log::info('User logged in successfully', ['user_id' => $user->id]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi berhasil! Registrasi selesai.',
                    'redirect' => route('home')
                ]);
            }

            return redirect()->route('home')
                ->with('success', 'Registrasi berhasil! Selamat datang di sistem NOC.');
        } catch (\Exception $e) {
            Log::error('OTP verification failed with error: ' . $e->getMessage(), [
                'email' => $request->email,
                'otp' => $request->otp,
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat verifikasi. Silakan coba lagi.'
                ], 500);
            }

            return back()->withErrors(['otp' => 'Terjadi kesalahan saat verifikasi. Silakan coba lagi.'])->withInput();
        }
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        Log::info('Resending OTP request', ['email' => $email]);

        try {
            // Find the latest verification record for this email
            $verification = EmailVerification::where('email', $email)
                ->where('is_used', false)
                ->latest()
                ->first();

            if (!$verification) {
                Log::warning('No pending verification found for resend', ['email' => $email]);

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada verifikasi tertunda untuk email ini.'
                    ], 422);
                }

                return back()->withErrors(['email' => 'Tidak ada verifikasi tertunda untuk email ini.'])->withInput();
            }

            Log::info('Found verification record for resend', ['verification_id' => $verification->id, 'registration_id' => $verification->registration_id]);

            // Delete any existing unused OTPs for this email
            EmailVerification::where('email', $email)
                ->where('is_used', false)
                ->delete();

            Log::info('Deleted existing unused OTPs', ['email' => $email]);

            // Get registration data from cache
            $registrationData = Cache::get('registration_' . $verification->registration_id);

            if (!$registrationData) {
                Log::warning('Registration data not found in cache for resend', ['registration_id' => $verification->registration_id]);

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data registrasi sudah kadaluarsa. Silakan daftar ulang.'
                    ], 422);
                }

                return back()->withErrors(['email' => 'Data registrasi sudah kadaluarsa. Silakan daftar ulang.'])->withInput();
            }

            Log::info('Registration data found in cache for resend', ['email' => $email]);

            // Generate new OTP
            $otp = EmailVerification::generateOtp();
            Log::info('New OTP generated for resend', ['email' => $email, 'otp' => $otp]);

            // Create new verification
            EmailVerification::create([
                'email' => $email,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(60),
                'is_used' => false,
                'registration_id' => $verification->registration_id,
            ]);

            Log::info('New verification record created for resend', ['email' => $email]);

            // Send new OTP email with error handling
            try {
                Mail::to($email)->send(new EmailVerificationOtp($otp));
                Log::info('Resend OTP email sent successfully', ['email' => $email]);

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'OTP baru telah dikirim ke email Anda.'
                    ]);
                }

                return back()->with('status', 'OTP baru telah dikirim ke email Anda.')
                    ->with('success', true);
            } catch (\Exception $e) {
                Log::error('Failed to send resend OTP email: ' . $e->getMessage(), ['email' => $email]);

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal mengirim OTP. Silakan coba lagi.'
                    ], 500);
                }

                return back()->with('status', 'Gagal mengirim OTP. Silakan coba lagi.')
                    ->with('error', true);
            }
        } catch (\Exception $e) {
            Log::error('Resend OTP failed with error: ' . $e->getMessage(), [
                'email' => $email,
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengirim ulang OTP. Silakan coba lagi.'
                ], 500);
            }

            return back()->withErrors(['email' => 'Terjadi kesalahan saat mengirim ulang OTP. Silakan coba lagi.'])->withInput();
        }
    }
}
