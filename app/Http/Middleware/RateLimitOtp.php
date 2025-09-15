<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RateLimitOtp
{
    public function handle(Request $request, Closure $next, $maxAttempts = 5, $decayMinutes = 1)
    {
        $key = 'otp-attempts:' . $request->ip() . ':' . ($request->email ?? 'unknown');
        
        if (Cache::has($key)) {
            $attempts = Cache::get($key);
            
            if ($attempts >= $maxAttempts) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Too many OTP attempts. Please try again later.'
                    ], 429);
                }
                
                return back()->withErrors([
                    'otp' => 'Terlalu banyak percobaan OTP. Silakan coba lagi nanti.'
                ])->withInput();
            }
            
            Cache::increment($key);
        } else {
            Cache::put($key, 1, $decayMinutes * 60);
        }

        return $next($request);
    }
}
