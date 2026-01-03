@extends('layouts.frontend')

@section('title', 'Order Success')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-beauty-text mb-4">Order Placed Successfully!</h1>
        <p class="text-gray-600 mb-8">Thank you for your purchase. Your order has been received and is being processed.</p>
        
        <div class="bg-beauty-bg rounded-lg p-6 mb-8">
            <p class="text-sm text-gray-600 mb-2">Order Number</p>
            <p class="text-2xl font-bold text-beauty-btn">#{{ $order->id }}</p>
        </div>
        
        <div class="text-left mb-8">
            <h2 class="font-bold text-lg mb-4">Order Details</h2>
            <div class="space-y-2">
                @foreach($order->items as $item)
                <div class="flex justify-between">
                    <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                    <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                </div>
                @endforeach
                <div class="border-t pt-2 flex justify-between font-bold">
                    <span>Total</span>
                    <span class="text-beauty-btn">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
        
        <div class="flex gap-4 justify-center">
            <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-beauty-btn text-white rounded-full hover:bg-secondary transition">
                View Orders
            </a>
            <a href="{{ route('shop.index') }}" class="px-6 py-3 border-2 border-beauty-btn text-beauty-btn rounded-full hover:bg-beauty-btn hover:text-white transition">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
