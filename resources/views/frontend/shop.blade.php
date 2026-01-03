@extends('layouts.frontend')

@section('title', 'Shop - All Products')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Mobile Filter Toggle -->
            <div class="lg:hidden mb-4">
                <button onclick="document.getElementById('mobile-filters').classList.remove('translate-x-full', 'invisible'); document.getElementById('mobile-filters-overlay').classList.remove('hidden');" 
                        class="w-full flex items-center justify-center space-x-2 bg-white border border-pink-200 text-gray-700 py-3 rounded-xl shadow-sm hover:bg-pink-50 transition">
                    <svg class="w-5 h-5 text-beauty-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <span class="font-bold">Show Filters</span>
                </button>
            </div>

            <!-- Filters Sidebar -->
            <div id="mobile-filters-overlay" class="fixed inset-0 bg-black/50 z-[100] hidden lg:hidden transition-opacity" 
                 onclick="this.classList.add('hidden'); document.getElementById('mobile-filters').classList.add('translate-x-full', 'invisible');"></div>

            <aside id="mobile-filters" class="fixed inset-y-0 right-0 w-80 bg-white z-[101] transform translate-x-full invisible transition-all duration-300 lg:static lg:w-72 lg:transform-none lg:visible lg:block lg:z-30 flex-shrink-0 overflow-y-auto lg:overflow-visible shadow-2xl lg:shadow-none">
                <div class="p-6 lg:p-0 h-full">
                    <!-- Mobile Close Button -->
                    <div class="flex items-center justify-between lg:hidden mb-6">
                        <h3 class="font-bold text-xl text-gray-900">Filters</h3>
                        <button onclick="document.getElementById('mobile-filters').classList.add('translate-x-full', 'invisible'); document.getElementById('mobile-filters-overlay').classList.add('hidden');" 
                                class="p-2 rounded-full hover:bg-gray-100 text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-gradient-to-br from-pink-50 to-white rounded-xl shadow-md border border-pink-100 p-6 sticky top-24">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-xl text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-beauty-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filters
                        </h3>
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('shop.index') }}" class="text-xs text-beauty-btn hover:text-secondary font-medium">Clear All</a>
                        @endif
                    </div>
                    
                    <form action="{{ route('shop.index') }}" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Search Products</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Search..."
                                       id="searchInput"
                                       class="w-full pl-10 pr-4 py-2.5 border-2 border-pink-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-beauty-btn focus:border-beauty-btn transition">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Category -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Category</label>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                <label class="flex items-center p-2 rounded-lg hover:bg-pink-100 transition cursor-pointer">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} 
                                           class="w-4 h-4 text-beauty-btn focus:ring-beauty-btn border-gray-300 filter-input">
                                    <span class="ml-3 text-sm font-medium text-gray-700">All Categories</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center p-2 rounded-lg hover:bg-pink-100 transition cursor-pointer">
                                        <input type="radio" name="category" value="{{ $cat->id }}" 
                                               {{ request('category') == $cat->id ? 'checked' : '' }}
                                               class="w-4 h-4 text-beauty-btn focus:ring-beauty-btn border-gray-300 filter-input">
                                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Price Range -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Price Range</label>
                            <div class="flex gap-3 items-center">
                                <div class="flex-1">
                                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" 
                                           class="w-full px-3 py-2.5 border-2 border-pink-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-beauty-btn focus:border-beauty-btn text-sm price-input">
                                </div>
                                <span class="text-gray-400">-</span>
                                <div class="flex-1">
                                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" 
                                           class="w-full px-3 py-2.5 border-2 border-pink-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-beauty-btn focus:border-beauty-btn text-sm price-input">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </aside>
            
            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Header with Sort -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                                @if(request('category'))
                                    {{ $categories->find(request('category'))->name ?? 'All Products' }}
                                @elseif(request('search'))
                                    Search Results
                                @else
                                    All Products
                                @endif
                            </h1>
                            <p class="text-sm text-gray-600 mt-1">
                                <span class="font-semibold text-beauty-btn">{{ $products->total() }}</span> products found
                            </p>
                        </div>
                        
                        <!-- Sort Dropdown -->
                        <div class="flex items-center gap-2">
                            <label class="text-sm font-medium text-gray-700 whitespace-nowrap">Sort by:</label>
                            <select name="sort" form="filterForm"
                                    class="px-4 py-2 border-2 border-pink-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-beauty-btn focus:border-beauty-btn text-sm font-medium">
                                <option value="">Default</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Products Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($products as $product)
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
                                
                                <!-- Stock Badge -->
                                @if($product->stock < 10 && $product->stock > 0)
                                    <span class="absolute top-2 right-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-md">
                                        Only {{ $product->stock }} left
                                    </span>
                                @elseif($product->stock == 0)
                                    <span class="absolute top-2 right-2 bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded-md">
                                        Out of Stock
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
                                <div class="text-xs text-gray-500 uppercase font-semibold mb-1 tracking-wider">{{ $product->category->name }}</div>
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
                    @empty
                        <div class="col-span-full text-center py-16">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-xl font-bold text-gray-600 mb-2">No products found</h3>
                            <p class="text-gray-500 mb-4">Try adjusting your filters or search terms</p>
                            <a href="{{ route('shop.index') }}" class="inline-block px-6 py-3 bg-beauty-btn text-white rounded-full hover:bg-secondary transition font-bold">
                                Clear Filters
                            </a>
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links('vendor.pagination.beauty') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick View Modal (reuse from home page) -->
<div id="quickViewModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeQuickView()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full relative">
            <button onclick="closeQuickView()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 z-10">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start gap-8" id="quickViewContent">
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
// Auto-submit filters functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const priceInputs = document.querySelectorAll('.price-input');
    
    let searchTimeout;
    let priceTimeout;
    
    // Search input - auto-submit after 500ms of no typing
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                filterForm.submit();
            }, 500);
        });
    }
    
    // Price inputs - auto-submit after 800ms of no typing
    priceInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            clearTimeout(priceTimeout);
            priceTimeout = setTimeout(function() {
                filterForm.submit();
            }, 800);
        });
    });

    // Auto-submit for Radio Buttons (Categories) and Select (Sort)
    const autoSubmitElements = document.querySelectorAll('.filter-input, select[name="sort"]');
    autoSubmitElements.forEach(function(el) {
        el.addEventListener('change', function() {
            filterForm.submit();
        });
    });
});

// Quick View functions (reuse from home page)
function openQuickView(productId) {
    const modal = document.getElementById('quickViewModal');
    const content = document.getElementById('quickViewContent');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    content.innerHTML = `
        <div class="w-full flex justify-center py-20">
            <svg class="animate-spin h-10 w-10 text-beauty-btn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    `;
    
    const product = productsData.find(p => p.id === productId);
    
    if(product) {
        populateQuickView(product);
    } else {
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
const productsData = @json($products->items());
</script>
@endpush
