<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-md mx-auto p-8 border-2 border-lime-500">

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email/Username Field -->
            <div class="relative">
                <x-text-input 
                    id="email" 
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent peer" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder=" " />
                <x-input-label 
                    for="email" 
                    class="absolute left-3 top-2 text-gray-500 transition-all duration-200 pointer-events-none peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:top-2 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:translate-y-[-18px] peer-focus:bg-white peer-focus:px-1" 
                    :value="__('username')" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password Field -->
            <div class="relative mt-8">
                <x-text-input 
                    id="password" 
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent peer"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder=" " />
                <x-input-label 
                    for="password" 
                    class="absolute left-3 top-2 text-gray-500 transition-all duration-200 pointer-events-none peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:top-2 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:translate-y-[-18px] peer-focus:bg-white peer-focus:px-1" 
                    :value="__('password')" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div class="mt-6">
                <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <style>
        /* Additional styling for the floating labels */
        .peer:focus ~ .peer-focus\:translate-y-\[-18px\] {
            transform: translateY(-18px);
        }
        .peer:not(:placeholder-shown) ~ .peer-placeholder-shown\:top-2 {
            top: -0.5rem;
            font-size: 0.875rem;
            color: #2563eb;
            background-color: white;
            padding: 0 0.25rem;
        }
    </style>
</x-guest-layout>