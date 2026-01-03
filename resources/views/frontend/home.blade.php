@extends('layouts.frontend')

@section('title', 'Home - Premium Beauty Products')

@section('content')
<!-- Full Width Video Banner -->
<div class="relative w-full h-[60vh] sm:h-[70vh] md:h-[80vh] lg:h-screen min-h-[500px] lg:min-h-[800px] overflow-hidden shadow-lg group">
    <video autoplay muted loop playsinline class="w-full h-full object-cover">
        <source src="https://cdn.shopify.com/videos/c/o/v/28d589c804df4a6e8b46f8343019e432.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    
    <!-- Overlay Content -->
    <div class="absolute inset-0 bg-black/30 flex flex-col items-center justify-center text-center text-white px-4 sm:px-6 lg:px-8">
        <p class="text-sm sm:text-base md:text-lg lg:text-xl font-medium tracking-wide mb-2 animate-fade-in-up">Find Inspiration</p>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-serif font-bold mb-4 sm:mb-6 leading-tight animate-fade-in-up delay-100">
            Natural Mineral <br class="hidden sm:block"> Water Spray
        </h1>
        <a href="{{ route('shop.index') }}" class="group inline-flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-widest hover:text-beauty-btn transition animate-fade-in-up delay-200 border-b-2 border-white pb-1 hover:border-beauty-btn">
            Discover Now
            <svg class="w-3 h-3 sm:w-4 sm:h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
</div>

<div class="bg-gray-50 min-h-screen">
    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left Sidebar (Banners) -->
            <div class="hidden lg:block lg:col-span-3 space-y-4 sticky top-24 h-fit">
                <!-- Banner 1 -->
                <div class="relative rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300 group">
                    <img src="https://beautymarket.ma/cdn/shop/files/l_oreal_pro_bannne.jpg?v=1765278967&width=750" 
                         alt="Special Offer" 
                         class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-6">
                        <p class="text-white text-xs font-bold tracking-widest uppercase mb-1 drop-shadow-md">New Collection</p>
                        <h3 class="text-white text-xl font-serif font-bold mb-4 drop-shadow-md">L'Oreal Pro</h3>
                        <a href="{{ route('shop.index') }}" class="inline-block bg-white text-black text-xs font-bold uppercase tracking-wider px-5 py-2 hover:bg-gray-100 transition w-fit shadow-md">
                            Explore More
                        </a>
                    </div>
                </div>
                
                <!-- Banner 2 -->
                <div class="relative rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300 group">
                    <img src="https://glowing-theme.myshopify.com/cdn/shop/files/banner-21.jpg?v=1736504096" 
                         alt="Blur Friday" 
                         class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-6">
                        <p class="text-white text-xs font-bold tracking-widest uppercase mb-1 drop-shadow-md">Flash Sale</p>
                        <h3 class="text-white text-xl font-serif font-bold mb-4 drop-shadow-md">Blue Friday</h3>
                        <a href="{{ route('shop.index') }}" class="inline-block bg-white text-black text-xs font-bold uppercase tracking-wider px-5 py-2 hover:bg-gray-100 transition w-fit shadow-md">
                            Shop Now
                        </a>
                    </div>
                </div>
                
                <!-- Banner 3 -->
                <div class="relative rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300 group">
                    <img src="https://beautymarket.ma/cdn/shop/files/BLURFRIDAY.jpg?v=1762973946&width=320" 
                         alt="Lips Collection" 
                         class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-6">
                        <p class="text-white text-xs font-bold tracking-widest uppercase mb-1 drop-shadow-md">Trending</p>
                        <h3 class="text-white text-xl font-serif font-bold mb-4 drop-shadow-md">Lips Collection</h3>
                        <a href="{{ route('shop.index') }}" class="inline-block bg-white text-black text-xs font-bold uppercase tracking-wider px-5 py-2 hover:bg-gray-100 transition w-fit shadow-md">
                            Discover
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-span-1 lg:col-span-9">
                




                <!-- Category Sections -->
                @foreach($categories as $category)
                    @if($category->products->count() > 0)
                    <div class="mb-12">
                        <!-- Section Header -->
                        <div class="flex justify-between items-end mb-6 border-b border-gray-100 pb-2">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                            </div>
                            <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="text-sm font-semibold text-beauty-btn hover:text-secondary flex items-center gap-1 transition">
                                View All 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                        </div>

                        <!-- Product Grid -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($category->products as $product)
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full overflow-hidden">
                                    <!-- Image -->
                                    <div class="relative aspect-[4/5] bg-gray-50 overflow-hidden">
                                        <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
                                            @php
                                                $firstImage = $product->images->first() ? $product->images->first()->image : null;
                                                $imagePath = $firstImage ? (str_starts_with($firstImage, 'http') ? $firstImage : asset('storage/' . $firstImage)) : null;
                                            @endphp
                                            
                                            @if($imagePath)
                                                <img src="{{ $imagePath }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                </div>
                                            @endif
                                        </a>

                                        <!-- Discount Badge -->
                                        @if($product->original_price > $product->price)
                                            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md">
                                                -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                            </span>
                                        @endif
                                        
                                        <!-- Actions -->
                                        <div class="absolute bottom-3 left-0 right-0 px-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex gap-2 justify-center">
                                             <button onclick="openQuickView({{ $product->id }})" class="bg-white text-gray-800 hover:text-beauty-btn p-2 rounded-full shadow-lg transition transform translate-y-4 group-hover:translate-y-0" title="Quick View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            </button>
                                            <button onclick="addToCart({{ $product->id }})" class="bg-beauty-btn text-white p-2 rounded-full shadow-lg hover:bg-secondary transition transform translate-y-4 group-hover:translate-y-0 delay-75" title="Add to Cart" {{ $product->stock == 0 ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Details -->
                                    <div class="p-4 flex flex-col flex-grow">
                                        <div class="text-xs text-gray-500 uppercase font-semibold mb-1 tracking-wider">{{ $category->name }}</div>
                                        <h3 class="text-gray-900 font-bold text-sm mb-2 line-clamp-2 hover:text-beauty-btn transition">
                                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="mt-auto flex items-center justify-between">
                                            <div class="flex flex-col">
                                                @if($product->original_price > $product->price)
                                                    <span class="text-xs text-gray-400 line-through">${{ number_format($product->original_price, 2) }}</span>
                                                @endif
                                                <span class="text-lg font-bold text-beauty-btn">${{ number_format($product->price, 2) }}</span>
                                            </div>
                                            <!-- Add button for mobile -->
                                            <button onclick="addToCart({{ $product->id }})" class="lg:hidden text-beauty-btn border border-beauty-btn px-3 py-1 rounded-full text-xs font-bold hover:bg-beauty-btn hover:text-white transition" {{ $product->stock == 0 ? 'disabled' : '' }}>
                                                {{ $product->stock == 0 ? 'Out' : 'Add' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach

               
            </div>
        </div>

        <!-- Promotional Banners Section (Full Width) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-12">
            <!-- Banner 1: Intensive Glow -->
            <div class="relative h-[300px] md:h-[350px] rounded-lg overflow-hidden group shadow-md hover:shadow-xl transition duration-300">
                <img src="https://glowing-theme.myshopify.com/cdn/shop/files/banner-01.jpg?v=1736504079" alt="Intensive Glow C+ Serum" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                <div class="absolute inset-0 flex flex-col justify-center px-8 md:px-12">
                    <span class="text-xs font-bold tracking-widest text-gray-500 uppercase mb-2">New Collection</span>
                    <h3 class="text-2xl md:text-3xl font-serif text-gray-900 mb-4 leading-tight">Intensive Glow C+ <br> Serum</h3>
                    <div>
                        <a href="{{ route('shop.index') }}" class="inline-block px-6 py-2.5 bg-white border border-gray-900 text-gray-900 text-sm font-semibold hover:bg-gray-900 hover:text-white transition duration-300">
                            Explore More
                        </a>
                    </div>
                </div>
            </div>

            <!-- Banner 2: 25% Off -->
            <div class="relative h-[300px] md:h-[350px] rounded-lg overflow-hidden group shadow-md hover:shadow-xl transition duration-300">
                <img src="https://glowing-theme.myshopify.com/cdn/shop/files/banner-02.jpg?v=1736504079" alt="25% off Everything" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                <div class="absolute inset-0 flex flex-col justify-center px-8 md:px-12">
                    <h3 class="text-2xl md:text-3xl font-serif text-gray-900 mb-2">25% off Everything</h3>
                    <p class="text-gray-600 mb-6 text-sm md:text-base max-w-[250px]">Makeup with extended range in colors for every human.</p>
                    <div>
                        <a href="{{ route('shop.index') }}" class="inline-block px-6 py-2.5 bg-white border border-gray-900 text-gray-900 text-sm font-semibold hover:bg-gray-900 hover:text-white transition duration-300">
                            Shop Sale
                        </a>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
</div>

<!-- Quick View Modal Overlay -->
<div id="quickViewModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeQuickView()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full relative">
            <button onclick="closeQuickView()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 z-10">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start gap-8" id="quickViewContent">
                    <!-- Loading State -->
                    <div class="w-full flex justify-center py-20">
                        <svg class="animate-spin h-10 w-10 text-beauty-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
        

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>


// Quick View Logic
function openQuickView(productId) {
    const modal = document.getElementById('quickViewModal');
    const content = document.getElementById('quickViewContent');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent scrolling
    
    // Show Loading
    content.innerHTML = `
        <div class="w-full flex justify-center py-20">
            <svg class="animate-spin h-10 w-10 text-beauty-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    `;

    // Fetch Product Data (we can repurpose the product.show view or just mock it for now since we have the data)
    // IMPORTANT: Since we don't have a dedicated JSON API endpoint for products yet, we will construct the content
    // dynamically using Javascript if we have the data, OR we fetch the product page text and parse it? 
    // Easier: Create a quick backend route OR just render the partial. 
    // FOR NOW: I'll simulate it by generating the HTML for the products that are already on screen. 
    // However, the cleanest way is to use the existing data if possible, but PHP variables aren't strictly accessible in JS unless passed.
    // I will making a fetch to a new simple endpoint, or just for this demo, I will pass the 'featuredProducts' as JSON to JS.
    
    // Let's use the passing JSON approach for simplicity as I can't easily add a controller method without user approval.
    const product = productsData.find(p => p.id === productId);
    
    if(product) {
        populateQuickView(product);
    } else {
        // Fallback or error
        content.innerHTML = '<p class="text-center text-red-500 py-10">Product not found.</p>';
    }
}

function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

function populateQuickView(product) {
    const content = document.getElementById('quickViewContent');
    
    let imagesHtml = '';
    // Handle image path logic similar to PHP
    let mainImage = null;
    if(product.images && product.images.length > 0) {
        let firstImg = product.images[0].image;
        mainImage = firstImg.startsWith('http') ? firstImg : '/storage/' + firstImg;
    }
    
    content.innerHTML = `
        <div class="w-full md:w-1/2 mb-6 md:mb-0">
             <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden relative">
                 ${mainImage ? `<img src="${mainImage}" class="w-full h-full object-cover">` : `<div class="w-full h-full flex items-center justify-center text-gray-300"><svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`}
             </div>
        </div>
        <div class="w-full md:w-1/2 md:pl-8 flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">${product.name}</h2>
            <div class="mb-4">
                <span class="text-2xl font-bold text-beauty-btn">$${parseFloat(product.price).toFixed(2)}</span>
                ${(product.original_price && product.original_price > product.price) ? `<span class="ml-2 text-sm text-gray-400 line-through">$${parseFloat(product.original_price).toFixed(2)}</span>` : ''}
            </div>
            <p class="text-gray-600 mb-6 text-sm leading-relaxed">${product.description || 'No description available.'}</p>
            
            <div class="mt-auto">
                <form action="/cart/add" method="POST">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                    <input type="hidden" name="product_id" value="${product.id}">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-3 py-2 text-gray-600 hover:bg-gray-100">-</button>
                            <input type="number" name="quantity" value="1" min="1" max="${product.stock}" class="w-12 text-center border-none focus:ring-0">
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
                        </div>
                        <span class="text-sm text-gray-500">${product.stock > 0 ? `${product.stock} in stock` : 'Out of stock'}</span>
                    </div>
                    <button type="submit" 
                            class="w-full bg-beauty-btn text-white py-3 px-6 rounded-lg hover:bg-secondary transition disabled:opacity-50 disabled:cursor-not-allowed"
                            ${product.stock == 0 ? 'disabled' : ''}>
                        ${product.stock > 0 ? 'Add to Cart' : 'Out of Stock'}
                    </button>
                </form>
            </div>
        </div>
    `;
}

// Pass PHP data to JS
const productsData = @json($featuredProducts);
</script>
@endpush
