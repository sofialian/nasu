<x-guest-layout>
    @php
    $labelClasses = 'font-medium text-sm font-body px-2
    absolute left-0 top-2 transition-all duration-200 pointer-events-none peer-placeholder-shown:text-base
    peer-placeholder-shown:top-2 peer-focus:top-2 peer-focus:text-primary-dark peer-focus:text-sm
    peer-focus:translate-y-[-12px] peer-focus:px-1';
    @endphp

    <div class="max-w-md mx-auto text-primary-dark">
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <!-- Name -->
            <div class="relative">
                <x-text-input
                    id="name"
                    class="block w-full"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder=" " />
                <x-input-label
                    for="name"
                    :value="__('Name')"
                    class="{{ $labelClasses }}" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="relative mt-8">
                <x-text-input
                    id="email"
                    class="block w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                    placeholder=" " />
                <x-input-label
                    for="email"
                    :value="__('Email')"
                    class="{{ $labelClasses }}" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- confirm email -->
            <div class="relative mt-8">
                <x-text-input
                    id="email_confirmation" {{-- Importante: el ID y el name deben ser 'email_confirmation' --}}
                    class="block w-full"
                    type="email"
                    name="email_confirmation" {{-- Importante: el ID y el name deben ser 'email_confirmation' --}}
                    required
                    autocomplete="email"
                    placeholder=" " />
                <x-input-label
                    for="email_confirmation"
                    :value="__('Confirm Email')" {{-- Texto para la etiqueta --}}
                    class="{{ $labelClasses }}" />
                <x-input-error :messages="$errors->get('email_confirmation')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="relative mt-8">
                <x-text-input
                    id="password"
                    class="block w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder=" " />
                <x-input-label
                    for="password"
                    :value="__('Password')"
                    class="{{ $labelClasses }}" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="relative mt-8">
                <x-text-input
                    id="password_confirmation"
                    class="block w-full"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder=" " />
                <x-input-label
                    for="password_confirmation"
                    :value="__('Confirm Password')"
                    class="{{ $labelClasses }}" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex flex-col items-center justify-end mt-6">
                <x-primary-button class="ms-4 mt-8">
                    {{ __('Registrarse') }}
                </x-primary-button>

                <a class="text-sm text-primary-dark hover:underline" href="{{ route('login') }}">
                    {{ __('¿Ya tienes cuenta?') }}
                </a>

            </div>
        </form>
    </div>
</x-guest-layout>