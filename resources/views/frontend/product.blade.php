@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Product Images -->
            <div>
                @if($product->images->count() > 0)
                    <div class="aspect-square bg-white rounded-lg overflow-hidden shadow-lg mb-4 relative group cursor-zoom-in"
                        id="imageContainer">
                        @php
                            $firstImage = $product->images->first()->image;
                            $firstImagePath = str_starts_with($firstImage, 'http') ? $firstImage : asset('storage/' . $firstImage);
                        @endphp
                        <img id="mainImage" src="{{ $firstImagePath }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-200 origin-center group-hover:scale-150"
                            style="will-change: transform;">
                    </div>

                    <script>
                        const container = document.getElementById('imageContainer');
                        const img = document.getElementById('mainImage');

                        if (container && img) {
                            container.addEventListener('mousemove', function (e) {
                                const rect = container.getBoundingClientRect();
                                const x = e.clientX - rect.left;
                                const y = e.clientY - rect.top;

                                const xPercent = (x / rect.width) * 100;
                                const yPercent = (y / rect.height) * 100;

                                img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                            });

                            container.addEventListener('mouseleave', function () {
                                img.style.transformOrigin = 'center center';
                            });
                        }
                    </script>
                    @if($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->images as $image)
                                @php
                                    $thumbPath = str_starts_with($image->image, 'http') ? $image->image : asset('storage/' . $image->image);
                                @endphp
                                <div class="aspect-square bg-white rounded-lg overflow-hidden cursor-pointer border-2 border-transparent hover:border-primary transition"
                                    onclick="document.getElementById('mainImage').src='{{ $thumbPath }}'">
                                    <img src="{{ $thumbPath }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400">No Image Available</span>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div>
                <nav class="text-sm text-gray-500 mb-4">
                    <a href="{{ route('home') }}" class="hover:text-beauty-btn">Home</a> /
                    <a href="{{ route('shop.index') }}" class="hover:text-beauty-btn">Shop</a> /
                    <span>{{ $product->name }}</span>
                </nav>

                <h1 class="text-3xl font-bold text-beauty-text mb-2">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $product->category->name }}</p>

                <div class="mb-6">
                    <span class="text-4xl font-bold text-beauty-btn">${{ number_format($product->price, 2) }}</span>
                </div>

                <div class="mb-6">
                    <p class="text-gray-700">{{ $product->description }}</p>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Availability:</span>
                        @if($product->stock > 0)
                            <span class="text-green-600 font-bold">In Stock</span>
                        @else
                            <span class="text-red-600 font-bold">Out of Stock</span>
                        @endif
                    </p>
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex gap-4 items-center mb-4">
                            <label class="font-semibold">Quantity:</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                class="w-20 px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <button type="submit"
                            class="w-full md:w-auto px-8 py-3 bg-beauty-btn text-white rounded-full hover:bg-secondary transition text-lg font-semibold">
                            Add to Cart
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <section class="mt-16">
                <h2 class="text-2xl font-bold text-beauty-text mb-6">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="group bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition">
                            <a href="{{ route('product.show', $related->slug) }}">
                                <div class="aspect-square overflow-hidden bg-gray-100">
                                    @if($related->images->count() > 0)
                                        @php
                                            $firstRelImage = $related->images->first()->image;
                                            $relImagePath = str_starts_with($firstRelImage, 'http') ? $firstRelImage : asset('storage/' . $firstRelImage);
                                        @endphp
                                        <img src="{{ $relImagePath }}" alt="{{ $related->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-beauty-text mb-2">{{ $related->name }}</h3>
                                    <span class="text-lg font-bold text-beauty-btn">${{ number_format($related->price, 2) }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection