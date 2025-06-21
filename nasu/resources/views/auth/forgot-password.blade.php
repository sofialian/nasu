<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="relative">
            <x-text-input
                id="email"
                class="block w-full pt-6 pb-1 px-2 bg-transparent border-0 appearance-none focus:outline-none focus:ring-0 focus:border-accent peer"
                type="email"
                name="email"
                :value="old('email')"
                required
                placeholder=" " /> <!-- Important: keep this single space -->

            <x-input-label
                for="email"
                :value="__('Email')"
                class="font-medium text-sm font-body px-2 absolute left-0 top-2 transition-all duration-200 pointer-events-none 
               peer-placeholder-shown:text-base peer-placeholder-shown:top-6 peer-focus:top-2 
               peer-focus:text-primary-dark peer-focus:text-sm peer-focus:-translate-y-3" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-12">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>