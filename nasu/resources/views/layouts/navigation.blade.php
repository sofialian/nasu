<nav x-data="{ open: false, dropdownOpen: false }" class="bg-primary-light">
    <!-- Homepage Navbar (no auth) -->
    @if(request()->is('/'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo placeholder -->
            <!-- <div class="flex items-center">
                <a href="{{ url('/') }}">
                    <x-application-logo class="h-8 w-auto" />
                </a> -->
        </div>
    </div>
    @else
    <!-- Main Navbar (with auth) -->
    <div class="w-full absolute inset-0 px-6 lg:px-16 h-16">
        <div class="flex justify-between my-2">
            <!-- Logo and Links -->
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="h-7 w-auto hidden md:block" />
                        <span class="font-body font-bold text-secondary-color text-2xl md:hidden">nasu</span>
                    </a>
                </div>
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="#" :active="request()->routeIs('')">
                        {{ __('Habitación') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="#" :active="request()->routeIs('')">
                        {{ __('Contacto') }}
                    </x-nav-link>
                </div>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md transition">
                    <svg width="35" height="35" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="18.5" cy="18.5" r="18.5" fill="#FF4E4E" />
                        <circle cx="12" cy="19" r="2" fill="#FCFFEB" />
                        <circle cx="19" cy="19" r="2" fill="#FCFFEB" />
                        <circle cx="26" cy="19" r="2" fill="#FCFFEB" />
                    </svg>
                </button>
            </div>

            <!-- Desktop User Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative" x-data="{ dropdownOpen: false }" @click.away="dropdownOpen = false">
                    <button @click="dropdownOpen = !dropdownOpen" class="inline-flex items-center px-3 py-2 text-base font-body leading-4 font-bold rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition">
                        {{ Auth::user()->name }}
                        <svg class="ml-1 h-4 w-4" :class="{ 'transform rotate-180': dropdownOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" x-transition class="absolute right-0 mt-2 w-48 bg-primary-light border border-primary-dark shadow-lg z-50">
                        <x-dropdown-link href="{{ route('profile.edit') }}">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu (Full Page) -->
    <div x-show="open" x-transition class="fixed inset-0 z-50 bg-primary-light sm:hidden">
        <!-- Close Button (X) -->
        <div class="absolute top-4 right-4">
            <button @click="open = false" class="p-2 rounded-md text-primary-light hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                <svg width="37" height="43" viewBox="0 0 35 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="18.5" cy="24.5" r="18.5" fill="#FF4E4E" />
                    <path d="M25.3503 30.14C25.5103 30.36 25.5903 30.56 25.5903 30.74C25.5903 31.1 25.4303 31.42 25.1103 31.7C24.7903 31.96 24.4503 32.09 24.0903 32.09C23.7103 32.09 23.4103 31.94 23.1903 31.64L18.9603 26.18C17.7203 27.98 16.4603 29.79 15.1803 31.61C14.9403 31.95 14.5803 32.12 14.1003 32.12C13.7003 32.12 13.3503 31.99 13.0503 31.73C12.7703 31.45 12.6303 31.14 12.6303 30.8C12.6303 30.64 12.6703 30.48 12.7503 30.32C13.4303 29.42 14.9303 27.31 17.2503 23.99L13.0203 18.44C12.9203 18.3 12.8703 18.14 12.8703 17.96C12.8703 17.64 13.0403 17.34 13.3803 17.06C13.7203 16.78 14.0603 16.64 14.4003 16.64C14.7803 16.64 15.0503 16.76 15.2103 17L16.1403 18.2C16.8203 19.04 17.7203 20.2 18.8403 21.68L20.7903 18.89L22.1103 17C22.2903 16.74 22.5203 16.61 22.8003 16.61C23.2003 16.61 23.5703 16.77 23.9103 17.09C24.2503 17.41 24.4203 17.73 24.4203 18.05C24.4203 18.17 24.3903 18.28 24.3303 18.38L23.9703 18.89L20.5503 23.9L25.3503 30.14Z" fill="#FCFFEB" />
                </svg>
            </button>
        </div>

        <!-- Menu Content -->
        <div class="pt-16 px-6 font-title">
            @auth
            <!-- Dashboard Link -->
            <div class="pb-3 space-y-1">
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="block px-3 py-2 text-base font-medium">
                    <div class="flex items-center">
                        <span>{{ __('Home') }}</span>
                    </div>
                </x-responsive-nav-link>
            </div>

            <!-- User Section -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="px-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile') }}" :active="request()->routeIs('profile')" class="block px-3 py-2 text-base font-medium">
                        <div class="flex items-center">
                            <span>{{ __('Perfil') }}</span>
                        </div>
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-base font-medium text-gray-500 hover:text-gray-800">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="#" :active="request()->routeIs('room.show')" class="block px-3 py-2 text-base font-medium">
                        <div class="flex items-center">
                            <span>{{ __('Room') }}</span>
                        </div>
                    </x-responsive-nav-link>
                </div>

                <div class="mt-3 space-y-1">
                    Sobre nasu
                </div>

                <div class="mt-3 space-y-1">
                    Contacto
                </div>
            </div>
            @else
            <!-- Guest Links -->
            <div class="space-y-1">
                <x-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')" class="block px-3 py-2 rounded-md text-base font-medium">
                    <div class="flex items-center">
                        <span>{{ __('Login') }}</span>
                        <div x-show="request()->routeIs('login')" class="ml-2 w-2 h-2 bg-primary-dark rounded-full"></div>
                    </div>
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')" class="block px-3 py-2 rounded-md text-base font-medium">
                    <div class="flex items-center">
                        <span>{{ __('Register') }}</span>
                        <div x-show="request()->routeIs('register')" class="ml-2 w-2 h-2 bg-primary-dark rounded-full"></div>
                    </div>
                </x-responsive-nav-link>
            </div>
            @endauth
        </div>
    </div>
    @endif
</nav>