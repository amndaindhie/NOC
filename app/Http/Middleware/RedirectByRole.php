<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class RedirectByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Log access attempt
            Log::info('Access attempt', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_roles' => $user->roles()->pluck('name')->toArray(),
                'requested_route' => $request->path(),
                'is_admin_route' => $request->is('admin/*') || $request->is('admin'),
                'has_admin_role' => $user->hasRole('admin'),
            ]);

            // Blokir akses ke rute admin jika user bukan admin
            if (!$user->hasRole('admin')) {
                if ($request->is('admin/*') || $request->is('admin')) {
                    Log::warning('Unauthorized admin access attempt', [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'requested_route' => $request->path(),
                    ]);
                    
                    return redirect()->route('dashboard')
                        ->with('error', 'Anda tidak memiliki akses ke area admin.');
                }
            }
        }

        return $next($request);
    }
}
