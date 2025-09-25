<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\EmailVerificationOtp;
use App\Rules\AllowedEmailDomain;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function create()
    {
        return view('livewire.pages.auth.register');
    }

    public function store(Request $request)
    {
        Log::info('Registration process started for email: ' . $request->email);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new AllowedEmailDomain],
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Generate registration ID
            $registrationId = Str::uuid()->toString();

            // Store registration data in cache for 60 minutes
            Cache::put('registration_' . $registrationId, [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_length' => strlen($request->password),
            ], 3600);

            // Generate OTP
            $otp = EmailVerification::generateOtp();

            // Store OTP in email_verifications table
            EmailVerification::create([
                'email' => $request->email,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(60),
                'is_used' => false,
                'registration_id' => $registrationId,
            ]);

            Log::info('OTP generated and stored for email: ' . $request->email . ', OTP: ' . $otp);

            // Send OTP email with error handling
            try {
                Mail::to($request->email)->send(new EmailVerificationOtp($otp));
                Log::info('OTP email sent successfully to: ' . $request->email);
            } catch (\Exception $e) {
                Log::error('Failed to send OTP email to: ' . $request->email . ', Error: ' . $e->getMessage());
                // Continue anyway and show success message to user
            }

            // Check if request is AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP has been sent to your email. Please verify to complete registration.',
                    'email' => $request->email
                ]);
            }

            return redirect()->route('verification.otp.form')
                ->with('message', 'Registration OTP has been sent to your email. Please verify to complete registration.')
                ->with('email', $request->email)
                ->with('success', true);

        } catch (\Exception $e) {
            Log::error('Registration failed for email: ' . $request->email . ', Error: ' . $e->getMessage());

            // Check if request is AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred during the registration process. Please try again.',
                    'errors' => ['email' => ['An error occurred during the registration process. Please try again.']]
                ], 422);
            }

            return back()->withErrors([
                'email' => 'An error occurred during the registration process. Please try again.'
            ])->withInput();
        }
    }
}
