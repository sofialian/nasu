<section class="">
    <header class="mb-6">
        <h2 class="uppercase font-title text-xl text-primary-dark">
            {{ __('Información del Perfil') }}
        </h2>
        <p class="mt-2 text-gray-600">
            {{ __('Actualiza la información de tu perfil y dirección de correo electrónico.') }}
        </p>
    </header>
    @if (session('status') === 'profile-updated')
    <p x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 2000)"
        class="text-sm p-4 bg-green-100 text-green-700 rounded-lg">
        {{ __('Guardado.') }}
    </p>
    @endif
    <!-- Verification Form (hidden, functionality preserved) -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div class="relative">
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="block w-full peer"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                placeholder=" " />
            <x-input-label for="name" :value="__('Nombre')" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div class="relative">
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="block w-full peer"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                placeholder=" " />
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                <p class="text-sm text-yellow-700">
                    {{ __('Tu dirección de correo no está verificada.') }}

                    <button form="send-verification" class="underline text-yellow-600 hover:text-yellow-800">
                        {{ __('Haz click aquí para reenviar el correo de verificación.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-sm text-green-600">
                    {{ __('Se ha enviado un nuevo enlace de verificación a tu correo.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-center mt-8">
            <div class="flex items-center gap-4">
                <x-primary-button type="submit" class="px-6 py-2">
                    {{ __('Guardar') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</section>