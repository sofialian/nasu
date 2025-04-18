<x-app-layout>
@section('content')
<div class="flex-grow flex items-center justify-center h-screen flex flex-col bg-primary-light">
    <!-- Contenido principal centrado -->
    <div class="w-full max-w-md px-4 py-8 text-center">
        <!-- Animación del logo -->
        <div class="mb-8 animate-bounce mx-auto" style="width: fit-content;">
            <div class="h-20 w-20 border-3 border-secondary-color rounded-full flex items-center justify-center mx-auto text-secondary-color text-4xl font-logo">
                n
            </div>
        </div>

        <!-- Texto "nasu" -->
        <h1 class="text-2xl font-logo text-primary-dark mb-8">nasu</h1>

        <!-- Botones de acceso -->
        @auth
        <form method="GET" action="{{ route('dashboard') }}">
            @csrf
            <button type="submit" class="border-2 border-primary-dark shadow hover:border-accent text-primary-dark font-bold py-3 px-8 transition duration-300 mb-8 w-full sm:w-auto">
                Enter (Continuar a Dashboard)
            </button>
        </form>
        @else
        <div class="space-y-4">
            <a href="{{ route('login') }}" class="block bg-accent hover:bg-accent-dark text-white font-bold py-3 px-6 transition duration-300 text-center w-full sm:w-auto">
                Enter (Iniciar Sesión)
            </a>
            <p class="inline-block hover:text-accent-dark text-sm">
                New to nasu?
                <span class="text-accent hover:underline"><a href="{{ route('register') }}">Sign up</a></span>
            </p>
        </div>
        @endauth
    </div>
</div>
</div>
@endsection
</x-app-layout>