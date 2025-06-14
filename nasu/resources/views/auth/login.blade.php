<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-md mx-auto p-8 text-primary-dark">
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email/Field -->
            <div class="relative">
                <x-text-input
                    id="email"
                    class="block w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder=" " />

                <x-input-label
                    for="email"
                    class=""
                    :value="__('Correo')" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password Field -->
            <div class="relative mt-8">
                <x-text-input
                    id="password"
                    class="block w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder=" " />
                <x-input-label
                    for="password"
                    class=""
                    :value="__('Contraseña')" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-6">
                <label for="remember_me" class="inline-flex items-center">
                    <x-checkbox-input id="remember_me" name="remember"/>
                    <span class="ms-2 text-sm text-gray-600 mr-4">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Login Button -->
            <div class="mt-6">
                <x-primary-button class="w-full justify-center">
                    {{ __('Entrar') }}
                </x-primary-button>
            </div>

             @if (Route::has('password.request'))
                <a class="text-sm hover:underline" href="{{ route('password.request') }}">
                    {{ __('Olvidaste tu contraseña?') }}
                </a>
                @endif
        </form>
    </div>

    <style>
        /* Additional styling for the floating labels */
        .peer:focus~.peer-focus\:translate-y-\[-18px\] {
            transform: translateY(-18px);
        }

        .peer:not(:placeholder-shown)~.peer-placeholder-shown\:top-2 {
            top: -0.5rem;
            font-size: 0.875rem;
            color: #97D5CA;
            padding: 0 0.25rem;
        }
    </style>
</x-guest-layout>