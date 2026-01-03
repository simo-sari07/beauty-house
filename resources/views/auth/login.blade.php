<x-guest-layout>
    <div class="mb-8">
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 font-serif">
            Welcome back
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Please sign in to access your account
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-pink-600 hover:text-pink-500 transition" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 transition-colors"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="Min. 8 characters" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded" name="remember">
            <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                {{ __('Remember me') }}
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-beauty-btn hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all transform hover:-translate-y-0.5">
                {{ __('Sign in') }}
            </button>
        </div>
    </form>

    <div class="mt-8 border-t border-gray-100 pt-6">
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-pink-600 hover:text-pink-500 transition">
                    Create an account
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
