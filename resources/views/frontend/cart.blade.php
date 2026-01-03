@extends('layouts.frontend')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-beauty-text mb-8">Shopping Cart</h1>
    
    <!-- Success Alert Removed (Using Global Toast) -->
    
    @if($cartItems->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                @foreach($cartItems as $item)
                <div class="flex items-center gap-4 p-4 border-b last:border-b-0">
                    <div class="w-24 h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                        @php
                            $firstImage = $item->product->images->first() ? $item->product->images->first()->image : null;
                            $imagePath = $firstImage ? (str_starts_with($firstImage, 'http') ? $firstImage : asset('storage/' . $firstImage)) : null;
                        @endphp
                        
                        @if($imagePath)
                            <img src="{{ $imagePath }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="font-semibold text-beauty-text">{{ $item->product->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $item->product->category->name }}</p>
                        <p class="text-lg font-bold text-beauty-btn mt-1">${{ number_format($item->product->price, 2) }}</p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" 
                                   class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                            <button type="submit" class="text-sm text-beauty-btn hover:text-secondary">Update</button>
                        </form>
                        
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                <h2 class="text-xl font-bold text-beauty-text mb-4">Order Summary</h2>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold">Free</span>
                    </div>
                </div>
                
                <div class="border-t pt-4 mb-6">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span class="text-beauty-btn">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
                
                @auth
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-beauty-btn text-white text-center py-3 rounded-full hover:bg-secondary transition font-semibold">
                        Proceed to Checkout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full bg-beauty-btn text-white text-center py-3 rounded-full hover:bg-secondary transition font-semibold">
                        Login to Checkout
                    </a>
                @endauth
                
                <a href="{{ route('shop.index') }}" class="block w-full text-center py-3 text-beauty-btn hover:text-secondary transition mt-2">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h2 class="text-2xl font-bold text-gray-600 mb-4">Your cart is empty</h2>
        <a href="{{ route('shop.index') }}" class="inline-block px-8 py-3 bg-beauty-btn text-white rounded-full hover:bg-secondary transition">
            Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection
