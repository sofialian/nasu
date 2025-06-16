<section class="p-4">
    <header class="mb-6">
        <h2 class="uppercase font-title text-lg text-primary-dark">
            {{ __('Actualizar Contraseña') }}
        </h2>
        <p class="mt-2 text-gray-600">
            {{ __('Use una contraseña larga y aleatoria para mayor seguridad.') }}
        </p>
    </header>

    <!-- Status Messages -->
    @if (session('status') === 'password-updated')
    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ __('Contraseña actualizada correctamente.') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Current Password -->
        <div class="relative">
            <x-text-input id="current_password" name="current_password" type="password"
                class="block w-full peer" placeholder=" " required />
            <x-input-label for="current_password" :value="__('Contraseña Actual')" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="relative">
            <x-text-input id="password" name="password" type="password"
                class="block w-full peer" placeholder=" " required />
            <x-input-label for="password" :value="__('Nueva Contraseña')" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="relative">
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                class="block w-full peer" placeholder=" " required />
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex justify-center items-center mt-4 space-x-2">
            <div class="flex items-center gap-4">
                <x-primary-button type="submit" class="px-6 py-2">
                    {{ __('Guardar') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</section>