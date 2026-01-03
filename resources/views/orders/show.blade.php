@extends('layouts.frontend')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in-up">
            <div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('orders.index') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-pink-600 hover:bg-pink-50 transition shadow-sm border border-gray-100">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Order #{{ $order->id }}</h1>
                </div>
                <p class="text-gray-500 mt-2 ml-11">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            
            <div class="flex items-center gap-3 ml-11 sm:ml-0">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold capitalize shadow-sm border border-gray-100
                    @if($order->status == 'delivered') bg-green-50 text-green-700
                    @elseif($order->status == 'cancelled') bg-red-50 text-red-700
                    @elseif($order->status == 'shipped') bg-blue-50 text-blue-700
                    @else bg-yellow-50 text-yellow-700 @endif">
                    <span class="w-2 h-2 rounded-full mr-2
                        @if($order->status == 'delivered') bg-green-500
                        @elseif($order->status == 'cancelled') bg-red-500
                        @elseif($order->status == 'shipped') bg-blue-500
                        @else bg-yellow-500 @endif"></span>
                    {{ $order->status }}
                </span>
            </div>
        </div>

        <!-- Tracking Status Stepper -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden animate-fade-in-up delay-100">
            <div class="p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-8 border-b border-gray-50 pb-4">Tracking Status</h3>
                
                @php
                    $status = $order->status;
                    $steps = ['pending', 'confirmed', 'shipped', 'delivered'];
                    $currentStepIndex = array_search($status, $steps);
                    if ($status === 'cancelled') {
                        $currentStepIndex = -1; 
                    }
                @endphp

                @if($status === 'cancelled')
                        <div class="bg-red-50 border border-red-100 rounded-xl p-6 flex items-start gap-4">
                        <div class="p-2 bg-red-100 rounded-lg text-red-600">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-red-800 text-lg">Order Cancelled</h4>
                            <p class="text-red-600 mt-1">This order has been cancelled. If you have questions, please contact support.</p>
                        </div>
                    </div>
                @else
                    <div class="relative px-4">
                        <div class="absolute inset-0 top-4 lg:top-5 left-8 right-8 hidden md:block" aria-hidden="true">
                            <div class="h-1 w-full bg-gray-100 rounded-full">
                                <div class="h-1 bg-pink-500 rounded-full transition-all duration-1000" style="width: {{ $currentStepIndex >= 0 ? ($currentStepIndex / (count($steps) - 1)) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="relative flex flex-col md:flex-row justify-between gap-8 md:gap-0">
                            @foreach($steps as $index => $step)
                                <div class="flex md:flex-col items-center gap-4 md:gap-2 z-10">
                                    <div class="flex-shrink-0 transition-all duration-500 {{ $index <= $currentStepIndex ? 'scale-110' : '' }}">
                                        @if($index <= $currentStepIndex)
                                            <div class="h-10 w-10 lg:h-12 lg:w-12 rounded-full bg-gradient-to-r from-pink-500 to-pink-600 flex items-center justify-center shadow-lg shadow-pink-200 border-4 border-white">
                                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="h-10 w-10 lg:h-12 lg:w-12 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center">
                                                <span class="text-sm font-bold text-gray-400">{{ $index + 1 }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="md:text-center pt-2">
                                        <p class="text-sm font-bold uppercase tracking-wider {{ $index <= $currentStepIndex ? 'text-pink-600' : 'text-gray-400' }}">
                                            {{ ucfirst($step) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 animate-fade-in-up delay-200">
            <!-- Order Items -->
            <div class="xl:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                         <h3 class="text-lg font-bold text-gray-900">Items Ordered</h3>
                         <span class="px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-xs font-bold uppercase">{{ $order->items->count() }} Items</span>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            <div class="p-6 flex flex-col sm:flex-row items-center sm:items-start gap-6 hover:bg-gray-50/50 transition duration-150">
                                <div class="flex-shrink-0 relative group">
                                    <div class="h-24 w-24 bg-gray-100 rounded-xl overflow-hidden border border-gray-100">
                                        @php
                                            $productImage = $item->product->images->first();
                                            $imageSrc = $productImage ? (str_starts_with($productImage->image, 'http') ? $productImage->image : asset('storage/' . $productImage->image)) : 'https://via.placeholder.com/150';
                                        @endphp
                                        <img src="{{ $imageSrc }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                    </div>
                                </div>
                                <div class="flex-1 text-center sm:text-left">
                                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-gray-500 mb-3">Unit Price: ${{ number_format($item->price, 2) }}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-gray-100 text-gray-700">
                                        Qty: {{ $item->quantity }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="bg-gray-50 p-8 border-t border-gray-100">
                        <div class="flex flex-col gap-3 max-w-sm ml-auto">
                            <div class="flex justify-between text-base text-gray-600">
                                <p>Subtotal</p>
                                <p class="font-medium">${{ number_format($order->total, 2) }}</p>
                            </div>
                            <div class="flex justify-between text-base text-gray-600">
                                <p>Shipping</p>
                                <p class="font-medium text-green-600">Free</p>
                            </div>
                            <div class="border-t border-gray-200 my-2"></div>
                            <div class="flex justify-between text-xl font-extrabold text-gray-900">
                                <p>Total</p>
                                <p class="text-pink-600">${{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping & Info -->
            <div class="space-y-8 h-fit">
                <!-- Shipping Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Shipping Details
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Contact Person</p>
                            <p class="font-bold text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                            <p class="text-sm text-gray-600">{{ $order->user->phone ?? 'No phone provided' }}</p>
                        </div>
                        <div class="border-t border-gray-100 pt-6">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Delivery Address</p>
                            @if($order->user->address)
                                <p class="text-sm text-gray-800 leading-relaxed">
                                    {{ $order->user->address }}<br>
                                    {{ $order->user->city }}
                                </p>
                            @else
                                <p class="text-sm text-gray-400 italic">No address provided</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                     <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                             <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Payment Info
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-500">Method</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $order->payment_method }}</span>
                        </div>
                         <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Payment Status</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold capitalize
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
