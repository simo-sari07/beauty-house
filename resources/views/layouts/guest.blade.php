<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex bg-white">
            <!-- Left Side: Visual -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-pink-900 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
                     alt="Beauty House" 
                     class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay">
                <div class="absolute inset-0 bg-gradient-to-bl from-pink-600/90 via-purple-900/80 to-pink-900/90"></div>
                
                <div class="relative z-10 flex flex-col justify-between w-full h-full p-12 text-white">
                    <div>
                         <a href="/" class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-8 border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                         </a>
                         <h1 class="text-5xl font-bold font-serif mb-6 leading-tight">Reveal Your <br/>True Beauty</h1>
                         <p class="text-lg text-pink-100 max-w-md font-light leading-relaxed">Experience a curated collection of premium skincare and cosmetics designed to enhance your natural radiance.</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 text-pink-200">
                             <div class="flex -space-x-2 overflow-hidden">
                                 <img class="inline-block h-8 w-8 rounded-full ring-2 ring-pink-900" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=64&h=64" alt=""/>
                                 <img class="inline-block h-8 w-8 rounded-full ring-2 ring-pink-900" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=64&h=64" alt=""/>
                                 <img class="inline-block h-8 w-8 rounded-full ring-2 ring-pink-900" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=64&h=64" alt=""/>
                             </div>
                             <span class="text-sm font-medium">Join 10,000+ beauty enthusiasts</span>
                        </div>
                        <p class="text-xs text-pink-300/60">© {{ date('Y') }} Beauty House. All rights reserved.</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:w-1/2 xl:px-24 bg-white relative">
                 <!-- Mobile Logo (Visible only on small screens) -->
                 <div class="lg:hidden absolute top-8 left-8">
                     <a href="/" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-beauty-btn rounded-lg flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        </div>
                        <span class="font-bold text-xl text-gray-900">Beauty House</span>
                     </a>
                 </div>

                <div class="mx-auto w-full max-w-sm lg:w-96">
                     {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
