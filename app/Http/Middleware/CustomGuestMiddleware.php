<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated as BaseRedirectIfAuthenticated;

class CustomGuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // If user is Admin and trying to access User Login/Register routes
                // Log them out to allow them to sign in as a user
                if ($request->is('login') || $request->is('register')) {
                     $user = Auth::guard($guard)->user();
                     if ($user->role === 'admin') {
                         Auth::guard($guard)->logout();
                         $request->session()->invalidate();
                         $request->session()->regenerateToken();
                         // Proceed as guest now
                         return $next($request);
                     }
                }

                // Default Redirect Logic
                return redirect($this->redirectTo($request));
            }
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (Auth::user()->role === 'admin') {
            return route('admin.dashboard');
        }
        return route('dashboard');
    }
}
