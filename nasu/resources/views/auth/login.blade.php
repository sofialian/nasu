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
                    <x-checkbox-input id="remember_me" name="remember" />
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
            <a class="text-base font-medium font-body mt-4 hover:underline" href="{{ route('password.request') }}">
                {{ __('¿Olvidaste tu contraseña?') }}
            </a>
            @endif
        </form>

        <p class="inline-block hover:text-primary-dark text-sm">
            O si no tienes cuenta, 
            <span class="text-accent hover:underline"><a href="{{ route('register') }}">regístrate</a></span>
        </p>
    </div>
</x-guest-layout>