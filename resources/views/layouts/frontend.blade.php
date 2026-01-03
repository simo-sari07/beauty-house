<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Beauty House') }} - @yield('title', 'Premium Beauty Products')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
    
        .hero-slider {
            position: relative;
            overflow: hidden;
        }
        .hero-slide {
            display: none;
            animation: fadeIn 1s ease-in-out;
        }
        .hero-slide.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Hero Content Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out forwards;
            opacity: 0;
        }

        .delay-100 {
            animation-delay: 0.2s;
        }


        .delay-200 {
            animation-delay: 0.4s;
        }

        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
  
    </style>
</head>
<body class="font-sans antialiased bg-beauty-bg">
    <!-- Header -->
    @php
        $isHome = Route::is('home');
    @endphp

    <header id="main-header" class="{{ $isHome ? 'absolute' : '' }} w-full top-0 z-50 transition-all duration-300 {{ $isHome ? 'bg-transparent text-white' : 'bg-white text-gray-800 shadow-sm' }}">
        <!-- Main Header -->
        <div id="header-border" class="border-b {{ $isHome ? 'border-transparent' : 'border-gray-200' }} transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center transition-colors duration-300" id="header-logo">
                            <span class="text-3xl mr-2">🌸</span>
                            <span>Beauty zin</span>
                        </a>
                    </div>

                    <!-- Search Bar (Desktop) -->
                    <!-- We might need to adjust search bar styling for transparent header -->
                    <div class="hidden md:flex flex-1 max-w-2xl mx-8 relative group">
                        <form action="{{ route('shop.index') }}" method="GET" class="w-full relative">
                            <!-- Input Wrapper -->
                            <div id="search-container" class="relative flex items-center w-full rounded-lg overflow-hidden h-11 transition-all duration-300 {{ $isHome ? 'bg-white/20 border-transparent text-white' : 'bg-white border-2 border-orange-500 text-gray-700' }}">
                                <input 
                                    type="text" 
                                    name="search" 
                                    id="desktop-search-input"
                                    placeholder="Search Products..." 
                                    class="w-full px-4 text-sm outline-none border-none focus:ring-0 h-full bg-transparent placeholder-current transition-colors"
                                    autocomplete="off"
                                >
                                
                                <!-- Search Button -->
                                <button type="submit" class="px-4 h-full flex items-center justify-center transition-colors {{ $isHome ? 'text-white hover:text-gray-200' : 'text-gray-600 hover:text-orange-600' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                        
                        <!-- Search Results Dropdown -->
                        <div id="search-results" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-b-lg shadow-xl z-50 hidden mt-1 divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
                            <!-- Results will be injected here via JS -->
                        </div>
                    </div>

                    <!-- Right Menu (Desktop) -->
                    <div class="hidden md:flex items-center space-x-6">
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative transition-colors duration-300 hover:opacity-75" id="header-cart">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            @if($cartCount > 0)
                            <span class="cart-count-badge absolute -top-2 -right-2 bg-beauty-btn text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                            @else
                            <span class="cart-count-badge absolute -top-2 -right-2 bg-beauty-btn text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">
                                0
                            </span>
                            @endif
                        </a>
                        
                        @if(auth()->check() && auth()->user()->role !== 'admin')
                            <!-- User Profile -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2 transition-colors duration-300 hover:opacity-75" id="header-user">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-sm font-medium">
                                        {{ auth()->user()->name }}
                                    </span>
                                </button>
                                <!-- Dropdown -->
                                <div class="absolute right-0 w-48 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 ease-in-out z-50">
                        <div class="bg-white rounded-xl shadow-lg border border-pink-100 overflow-hidden">
                            <div class="px-4 py-3 border-b border-pink-50 bg-pink-50/30">
                                <p class="text-sm leading-5 font-medium text-beauty-text truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs leading-4 text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-beauty-pink transition-colors">
                                Dashboard
                            </a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-beauty-pink transition-colors">
                                My Orders
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-beauty-pink transition-colors">
                                My Profile
                            </a>
                            
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium transition-colors duration-300 hover:opacity-75" id="header-login">Sign In / Register</a>
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden transition-colors duration-300 hover:opacity-75">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Category Navigation -->
        <nav id="header-nav" class="border-b transition-colors duration-300 {{ $isHome ? 'bg-transparent border-transparent' : 'bg-white border-gray-200' }}">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex space-x-8 py-3 overflow-x-auto no-scrollbar">
                    <a href="{{ route('shop.index') }}" class="text-sm font-medium text-beauty-btn hover:text-secondary transition whitespace-nowrap">All Products</a>
                    @foreach($categories as $category)
                        <a href="{{ route('shop.index', ['category' => $category->id]) }}" 
                           class="text-sm font-medium transition-colors hover:text-beauty-btn whitespace-nowrap {{ $isHome ? 'text-white' : 'text-gray-700' }} nav-link">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>
      

        <!-- Mobile Menu (Full Screen Overlay) -->
        <div id="mobile-menu" class="fixed inset-0 z-[200] hidden md:hidden bg-white overflow-y-auto transition-transform duration-300">
            <!-- Mobile Menu Header -->
            <div class="sticky top-0 z-10 px-6 py-4 flex items-center justify-between bg-white/90 backdrop-blur-md border-b border-pink-100 shadow-sm">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="relative w-8 h-8 flex items-center justify-center bg-gradient-to-tr from-beauty-btn to-pink-400 rounded-lg shadow-md transform group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-900 group-hover:text-beauty-btn transition-colors">Beauty House</span>
                </a>

                <!-- Close Button -->
                <button id="close-mobile-menu" class="p-2 -mr-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 py-6 space-y-6">
                <!-- Mobile Search -->
                <div>
                     <form action="{{ route('shop.index') }}" method="GET" class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search products..." 
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border-transparent focus:bg-white border-2 focus:border-beauty-btn rounded-xl focus:outline-none transition-all duration-300 font-medium text-gray-700 placeholder-gray-400"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </form>
                </div>

                <!-- Categories Section -->
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Categories</h3>
                    <div class="space-y-1">
                        <a href="{{ route('shop.index') }}" 
                           class="flex items-center px-4 py-3 text-beauty-btn bg-pink-50 border border-pink-100 rounded-xl font-bold hover:bg-beauty-btn hover:text-white transition-all duration-200 shadow-sm">
                            <span class="mr-3">🛍️</span> All Products
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('shop.index', ['category' => $category->id]) }}" 
                               class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all duration-200 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-pink-200 mr-3"></span>
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Mobile Cart -->
                <div class="pt-6 border-t border-gray-100">
                    <a href="{{ route('cart.index') }}" class="flex items-center justify-between px-4 py-3 text-gray-700 bg-white border border-gray-200 hover:border-beauty-btn hover:text-beauty-btn rounded-xl transition-all duration-200 font-medium group">
                        <span class="flex items-center gap-3">
                            <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-pink-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            Shopping Cart
                        </span>
                        @if($cartCount > 0)
                        <span class="cart-count-badge bg-beauty-btn text-white text-xs font-bold rounded-full px-2.5 py-1 shadow-sm group-hover:scale-110 transition-transform">{{ $cartCount }}</span>
                        @else
                        <span class="cart-count-badge bg-beauty-btn text-white text-xs font-bold rounded-full px-2.5 py-1 shadow-sm group-hover:scale-110 transition-transform hidden">0</span>
                        @endif
                    </a>
                </div>

                <!-- User Section -->
                <div class="pt-2 space-y-2">
                    @if(auth()->check() && auth()->user()->role !== 'admin')
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-full bg-beauty-btn text-white flex items-center justify-center font-bold text-lg shadow-md">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-1">
                                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-navy-900 hover:bg-white rounded-lg transition">Profile Settings</a>
                                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-navy-900 hover:bg-white rounded-lg transition">Dashboard</a>
                                <a href="{{ route('orders.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-navy-900 hover:bg-white rounded-lg transition">My Orders</a>
                            </div>
                            
                             <form method="POST" action="{{ route('logout') }}" class="mt-4 pt-4 border-t border-gray-200">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-red-500 bg-white border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-100 transition font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-3 text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition font-bold">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center justify-center px-4 py-3 bg-beauty-btn text-white hover:bg-secondary rounded-xl transition font-bold shadow-lg shadow-pink-200">
                                Register
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Success/Error Alerts -->
    <!-- Toast Notifications -->
    @if(session('success'))
    <div id="alert-success" class="fixed top-24 right-5 z-[200] max-w-sm w-full bg-white/90 backdrop-blur-md rounded-xl shadow-lg border border-green-100 overflow-hidden transform transition-all duration-300 animate-fade-in-left">
        <div class="p-4 flex items-start gap-4">
            <div class="flex-shrink-0 bg-green-50 rounded-full p-2">
                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="flex-1 pt-1">
                <p class="text-sm font-bold text-gray-900">Success</p>
                <p class="mt-1 text-sm text-gray-600">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('alert-success').remove()" class="text-gray-400 hover:text-gray-500 transition-colors">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <div class="h-1 bg-green-500 w-full animate-progress-bar"></div>
    </div>
    <script>
        setTimeout(() => {
            const el = document.getElementById('alert-success');
            if(el) {
                el.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => el.remove(), 300);
            }
        }, 4000);
    </script>
    <style>
        @keyframes progressBar {
            0% { width: 100%; }
            100% { width: 0%; }
        }
        .animate-progress-bar {
            animation: progressBar 4s linear forwards;
        }
        .animate-fade-in-left {
            animation: slideInRight 0.5s ease-out forwards;
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(100%); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
    @endif

    @if(session('error'))
    <div id="alert-error" class="fixed top-24 right-5 z-[200] max-w-sm w-full bg-white/90 backdrop-blur-md rounded-xl shadow-lg border border-red-100 overflow-hidden transform transition-all duration-300 animate-fade-in-left">
        <div class="p-4 flex items-start gap-4">
            <div class="flex-shrink-0 bg-red-50 rounded-full p-2">
                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <div class="flex-1 pt-1">
                <p class="text-sm font-bold text-gray-900">Error</p>
                <p class="mt-1 text-sm text-gray-600">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('alert-error').remove()" class="text-gray-400 hover:text-gray-500 transition-colors">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
         <div class="h-1 bg-red-500 w-full animate-progress-bar"></div>
    </div>
    @endif

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16 font-sans">
        <!-- Top Features Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1 -->
                <div class="flex items-start space-x-3 group">
                    <div class="text-beauty-btn">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm hover:text-beauty-btn transition">High Quality Selection</h4>
                        <p class="text-xs text-gray-500 mt-1">Total product quality control for peace of mind</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="flex items-start space-x-3 group">
                    <div class="text-beauty-btn">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm hover:text-beauty-btn transition">Affordable Prices</h4>
                        <p class="text-xs text-gray-500 mt-1">Factory direct prices for maximum savings</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="flex items-start space-x-3 group">
                    <div class="text-beauty-btn">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm hover:text-beauty-btn transition">Express Shipping</h4>
                        <p class="text-xs text-gray-500 mt-1">Fast, reliable delivery from global warehouse</p>
                    </div>
                </div>
                <!-- Feature 4 -->
                <div class="flex items-start space-x-3 group">
                    <div class="text-beauty-btn">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm hover:text-beauty-btn transition">Worry Free</h4>
                        <p class="text-xs text-gray-500 mt-1">Instant access to professional support</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Information -->
                <div>
                    <h5 class="font-bold text-gray-900 text-sm mb-4">Information</h5>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-beauty-btn transition">About Us</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Top Searches</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Terms and Conditions</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Testimonials</a></li>
                    </ul>
                </div>
                
                <!-- Customer Care -->
                <div>
                    <h5 class="font-bold text-gray-900 text-sm mb-4">Customer Care</h5>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-beauty-btn transition">My Account</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Track Order</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-beauty-btn transition">Shop</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Wishlist</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Returns/Exchange</a></li>
                    </ul>
                </div>

                <!-- Other Business -->
                <div>
                    <h5 class="font-bold text-gray-900 text-sm mb-4">Other Business</h5>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-beauty-btn transition">Partnership Programs</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Associate Program</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Wholesale Socks</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Wholesale Funny Socks</a></li>
                        <li><a href="#" class="hover:text-beauty-btn transition">Others</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h5 class="font-bold text-gray-900 text-sm mb-4">Newsletter</h5>
                    <form class="flex items-center">
                        <div class="relative w-full">
                            <input type="email" placeholder="Enter your email" class="w-full px-4 py-2 text-sm border border-gray-300 rounded-full focus:outline-none focus:border-beauty-btn focus:ring-1 focus:ring-beauty-btn">
                            <button type="submit" class="absolute right-0 top-0 bottom-0 bg-beauty-btn hover:bg-secondary text-white rounded-r-full px-4 transition duration-300 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    <p class="text-xs text-gray-400 mt-2">Subscribe to our newsletter to get updates.</p>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bg-gray-50 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Beauty House. All rights reserved.</p>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">We using safe payment for:</span>
                        <img src="https://babymart.reactbd.com/_next/static/media/payment.682e08dd.webp" alt="Payment Methods" class="h-6 w-auto object-contain">
                    </div>
                </div>
            </div>
        </div>
    </footer>


<script>
    // Search Autocomplete Logic
    const searchInput = document.getElementById('desktop-search-input');
    const searchResults = document.getElementById('search-results');
    let timeout = null;

    if (searchInput) {
        // Function to fetch and render
        function performSearch(query = '') {
            fetch(`{{ route('search.suggestions') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(products => {
                    searchResults.innerHTML = '';
                    
                    if (products.length > 0) {
                        searchResults.classList.remove('hidden');
                        
                        // Header
                        const header = document.createElement('div');
                        header.className = 'px-4 py-2 bg-gray-50 text-xs font-semibold text-gray-500 uppercase';
                        header.textContent = query.length < 2 ? 'Popular Products' : 'Search Results';
                        searchResults.appendChild(header);

                        products.forEach(product => {
                            const item = document.createElement('a');
                            // Navigate to shop page with filter
                            item.href = `{{ route('shop.index') }}?search=${encodeURIComponent(product.name)}`;
                            item.className = 'block px-4 py-2.5 hover:bg-gray-50 flex items-center gap-3 transition duration-150 group';
                            
                            item.innerHTML = `
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span class="text-sm text-gray-700 font-medium group-hover:text-gray-900">${product.name}</span>
                            `;
                            searchResults.appendChild(item);
                        });

                    } else if (query.length >= 2) {
                        searchResults.classList.remove('hidden');
                        searchResults.innerHTML = `
                            <div class="px-4 py-6 text-center text-gray-500">
                                <p class="text-sm">No products found</p>
                            </div>
                        `;
                    } else {
                         searchResults.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        }

        // On Input
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value;
            timeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });

        // On Focus (Show default/popular if empty)
        searchInput.addEventListener('focus', function() {
            if (this.value.length === 0) {
                performSearch(''); // Fetch defaults
            } else {
                searchResults.classList.remove('hidden');
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('main-header');
        const headerNav = document.getElementById('header-nav');
        const headerBorder = document.getElementById('header-border');
        const headerLogo = document.getElementById('header-logo');
        const navLinks = document.querySelectorAll('.nav-link');
        const searchContainer = document.getElementById('search-container');
        
        // Right Menu Items
        const headerCart = document.getElementById('header-cart');
        const headerUser = document.getElementById('header-user');
        const headerLogin = document.getElementById('header-login');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');

        const isHome = {{ json_encode(Route::is('home')) }};

        if (!header) return;

        // Scroll Header Logic for ALL pages
        function updateHeader() {
            const scrollY = window.scrollY;
            const heroHeight = window.innerHeight * 0.8;
            
            // Logic for Home Page (Transparent -> Pink)
            if (isHome) {
                 const scrolledPastHero = scrollY > heroHeight;
                 
                 // Position: Absolute initially, Fixed after hero
                 if (scrolledPastHero) {
                     header.classList.remove('absolute');
                     header.classList.add('fixed');
                 } else {
                     header.classList.remove('fixed');
                     header.classList.add('absolute');
                 }

                 // Appearance: Transparent -> Pink
                 if (scrollY > 50) {
                     // Scrolled State
                     header.classList.remove('bg-transparent', 'text-white');
                     header.classList.add('bg-pink-100', 'text-gray-800', 'shadow-sm');
                     
                     if(headerBorder) {
                         headerBorder.classList.remove('border-transparent');
                         headerBorder.classList.add('border-pink-200');
                     }
                     
                     // Nav Links & Icons Color
                     updateHeaderColors('dark');
                 } else {
                     // Top State
                     header.classList.add('bg-transparent', 'text-white');
                     header.classList.remove('bg-pink-100', 'text-gray-800', 'shadow-sm');

                     if(headerBorder) {
                         headerBorder.classList.add('border-transparent');
                         headerBorder.classList.remove('border-pink-200');
                     }

                     updateHeaderColors('light');
                 }
            } 
            // Logic for Other Pages (White -> Pink Sticky)
            else {
                // Always Sticky/Fixed when scrolled? Or only after some point?
                // User said "header like now [White] but when scroll background pink like home".
                // Currently it's static (relative). To be "like home" on scroll, it must become fixed.

                if (scrollY > 100) {
                    header.classList.remove('relative');
                    header.classList.add('fixed', 'top-0', 'w-full', 'animation-fade-down'); // Add animation for smooth entry
                    
                    // Pink Background
                    header.classList.remove('bg-white');
                    header.classList.add('bg-pink-100', 'shadow-sm');
                    
                    if(headerBorder) headerBorder.classList.add('border-pink-200');
                    if(headerBorder) headerBorder.classList.remove('border-gray-200');

                } else {
                    // Reset to default (Static White)
                    header.classList.add('relative', 'bg-white');
                    header.classList.remove('fixed', 'bg-pink-100', 'animation-fade-down', 'shadow-sm', 'top-0');
                    
                     if(headerBorder) headerBorder.classList.remove('border-pink-200');
                     if(headerBorder) headerBorder.classList.add('border-gray-200');
                }
                
                // Text is always dark on other pages, so no need to toggle text/icon colors unless "Pink" mode requires different colors than "White".
                // "Pink" mode on Home uses `text-gray-800`.
                // "White" mode on Shop uses `text-gray-800`.
                // So colors match.
            }
        }

        function updateHeaderColors(type) {
             const isDark = type === 'dark'; // Dark text (for light background)
             const textClassToAdd = isDark ? 'text-gray-700' : 'text-white';
             const textClassToRemove = isDark ? 'text-white' : 'text-gray-700';

             navLinks.forEach(link => {
                link.classList.remove(textClassToRemove);
                link.classList.add(textClassToAdd);
             });

             [headerCart, headerUser, headerLogin, mobileMenuBtn].forEach(el => {
                if(el) {
                    el.classList.remove(textClassToRemove);
                    el.classList.add(textClassToAdd);
                }
             });
             
             if(searchContainer) {
                 if(isDark) {
                     searchContainer.classList.remove('bg-white/20', 'border-transparent', 'text-white');
                     searchContainer.classList.add('bg-white', 'border-2', 'border-orange-500', 'text-gray-700');
                 } else {
                     searchContainer.classList.add('bg-white/20', 'border-transparent', 'text-white');
                     searchContainer.classList.remove('bg-white', 'border-2', 'border-orange-500', 'text-gray-700');
                 }
             }
             
             if(headerLogo) {
                 if(isDark) {
                     // On Pink/White header, logo might want 'text-beauty-btn' or default
                 } else {
                     headerLogo.classList.remove('text-beauty-btn');
                 }
             }
        }

        // Mobile Menu Logic
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMobileMenuBtn = document.getElementById('close-mobile-menu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent immediate closing if there's a click listener on document
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Lock scroll
            });
        }

        if (closeMobileMenuBtn && mobileMenu) {
            closeMobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = ''; // Unlock scroll
            });
        }

        // Close when clicking outside (optional, but good for overlay)
        /* 
        mobileMenu.addEventListener('click', (e) => {
             if(e.target === mobileMenu) {
                 mobileMenu.classList.add('hidden');
                 document.body.style.overflow = '';
             }
        });
        */

        window.addEventListener('scroll', updateHeader);
        updateHeader();
    });

    // Add to Cart AJAX Logic
    function addToCart(productId) {
        // Find existing form-like data
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update Cart Badges
                document.querySelectorAll('.cart-count-badge').forEach(badge => {
                    badge.textContent = data.cartCount;
                    badge.classList.remove('hidden');
                });
                
                // Show Modal
                const modal = document.getElementById('cart-success-modal');
                modal.classList.remove('hidden');
            }
        })
        .catch(error => console.error('Error adding to cart:', error));
    }
</script>

<!-- Add to Cart Success Modal -->
<div id="cart-success-modal" class="fixed inset-0 z-[300] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('cart-success-modal').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Product Added Successfully!
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                The item has been added to your shopping cart.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <a href="{{ route('cart.index') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-beauty-btn text-base font-medium text-white hover:bg-secondary focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    View Cart
                </a>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('cart-success-modal').classList.add('hidden')">
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>
