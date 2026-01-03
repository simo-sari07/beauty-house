<x-guest-layout>
    <div class="mb-8">
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 font-serif">
            Create Account
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Join us to get exclusive offers and rewards
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-medium" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 transition-colors" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 transition-colors" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 transition-colors"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Min. 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 transition-colors"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-beauty-btn hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all transform hover:-translate-y-0.5">
                {{ __('Create Account') }}
            </button>
        </div>
    </form>

    <div class="mt-8 border-t border-gray-100 pt-6">
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-pink-600 hover:text-pink-500 transition">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
