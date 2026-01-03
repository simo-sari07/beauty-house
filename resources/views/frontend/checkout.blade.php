@extends('layouts.frontend')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-beauty-text mb-8">Checkout</h1>
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-bold text-beauty-text mb-4">Shipping Address</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Full Name *</label>
                            <input type="text" name="fullname" required 
                                   value="{{ old('fullname', Auth::user()->name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Phone *</label>
                            <input type="tel" name="phone" required 
                                   value="{{ old('phone', Auth::user()->phone) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">City *</label>
                            <input type="text" name="city" required 
                                   value="{{ old('city', Auth::user()->city) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2">Address *</label>
                            <textarea name="address" rows="3" required 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">{{ old('address', Auth::user()->address) }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-bold text-beauty-text mb-4">Payment Method</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary transition">
                            <input type="radio" name="payment_method" value="cod" checked class="mr-3">
                            <div>
                                <p class="font-semibold">Cash on Delivery</p>
                                <p class="text-sm text-gray-500">Pay when you receive your order</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary transition">
                            <input type="radio" name="payment_method" value="stripe" class="mr-3">
                            <div>
                                <p class="font-semibold">Credit/Debit Card</p>
                                <p class="text-sm text-gray-500">Secure payment via Stripe</p>
                            </div>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-beauty-btn text-white py-3 rounded-full hover:bg-secondary transition font-semibold text-lg">
                    Place Order
                </button>
            </form>
        </div>
        
        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                <h2 class="text-xl font-bold text-beauty-text mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-4">
                    @foreach($cartItems as $item)
                    <div class="flex gap-3">
                        <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                            @if($item->product->images->count() > 0)
                                @php
                                    $image = $item->product->images->first();
                                    $imagePath = Str::startsWith($image->image, 'http') 
                                        ? $image->image 
                                        : asset('storage/' . $image->image);
                                @endphp
                                <img src="{{ $imagePath }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold">{{ $item->product->name }}</p>
                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                            <p class="text-sm font-bold text-beauty-btn">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold">Free</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-2 border-t">
                        <span>Total</span>
                        <span class="text-beauty-btn">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
