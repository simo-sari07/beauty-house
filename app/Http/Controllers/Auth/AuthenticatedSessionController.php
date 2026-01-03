<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $sessionId = session()->getId();
        $request->authenticate();

        Cart::mergeToUser(Auth::user(), $sessionId);

        // Check if user is admin - they should use /beauty-house-admin
        if (Auth::user()->role === 'admin') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Admin users must login via the admin panel.',
            ]);
        }

        $request->session()->regenerate();

        // Add success message
        session()->flash('success', 'Login successful! Welcome back.');

        return redirect()->intended(route('cart.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
