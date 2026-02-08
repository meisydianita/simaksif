<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckActiveGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeGuard = session('active_guard');
        

        if (!$activeGuard) {
            if (Auth::guard('user')->check()) {
                $activeGuard = 'user';
            } elseif (Auth::guard('anggota')->check()) {
                $activeGuard = 'anggota';
            }
            
            if ($activeGuard) {
                session(['active_guard' => $activeGuard]);
            }
        }
        
        return $next($request);
    }
}
