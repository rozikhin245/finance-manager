<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
            <a href="{{ route('google.login') }}" class="flex items-center justify-center bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                    <path fill="#4285F4" d="M44.5 20H24v8.5h11.9C33.1 32.1 30 35 26 36.3l6.1 4.5c5.5-3.6 8.8-9.4 8.8-16.3 0-1.1-.1-2.1-.3-3.2z"/>
                    <path fill="#34A853" d="M24 44c6.4 0 11.7-2.1 15.6-5.8l-6.1-4.5c-2.1 1.4-4.8 2.2-7.7 2.2-5.9 0-10.8-4-12.5-9.4l-6.2 4.8C11 38.2 17 44 24 44z"/>
                    <path fill="#FBBC05" d="M11.5 26.5c-.5-1.6-.8-3.3-.8-5s.3-3.4.8-5l-6.2-4.8C3.6 14.1 3 17 3 21s.6 6.9 1.7 9.8l6.2-4.8z"/>
                    <path fill="#EA4335" d="M24 10.5c3.3 0 6.2 1.1 8.5 3.2l6.4-6.4C34.5 3.1 29.3 1 24 1 17 1 11 6 8 13l6.2 4.8c1.7-5.4 6.6-9.3 12.5-9.3z"/>
                </svg>
                Login dengan Google
            </a>
            
        </div>
    </form>
</x-guest-layout>
