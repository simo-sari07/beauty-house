<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Cart;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class FrontendComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get all categories for navigation
        $categories = Category::orderBy('name')->get();
        
        // Get cart count
        $cartCount = 0;
        
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cartCount = $cart->items()->sum('quantity');
            }
        } else {
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)->first();
            if ($cart) {
                $cartCount = $cart->items()->sum('quantity');
            }
        }
        
        $view->with([
            'categories' => $categories,
            'cartCount' => $cartCount
        ]);
    }
}
