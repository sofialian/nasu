<section class="">
    <header class="mb-6">
        <h2 class="uppercase font-title text-xl text-primary-dark">
            {{ __('Eliminar Cuenta') }}
        </h2>
        <p class="mt-2 text-gray-600">
            {{ __('Una vez eliminada tu cuenta, todos sus recursos y datos serán borrados permanentemente. Descarga cualquier información importante antes de continuar.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-2">
        {{ __('Eliminar Cuenta') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="uppercase font-title text-xl text-primary-dark mb-4">
                {{ __('¿Estás seguro?') }}
            </h2>

            <p class="text-gray-600 mb-6">
                {{ __('Esta acción no puede deshacerse. Todos tus datos serán eliminados permanentemente.') }}
            </p>

            <div class="relative">
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full peer"
                    placeholder=" "
                    required />
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-4 mt-8">
                <x-secondary-button x-on:click="$dispatch('close')" class="w-1/2 px-6 py-2">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="px-6 py-2" type="submit">
                    {{ __('Eliminar Permanentemente') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>