@extends('layouts.app')
@section('content')

<div class="flex-grow flex items-center justify-center flex-col bg-primary-light">

    <!-- Contenido principal centrado -->
    <div class="w-full max-w-md px-4 py-8 text-center">
        <!-- Animación del logo -->
        <div class="mb-6 animate-bounce mx-auto" style="width: fit-content;">
            <x-application-logo class="w-14 h-14" />
        </div>

        <!-- Texto "nasu" -->
        <div class="text-3xl font-body font-bold text-primary-dark mb-8">nasu</div>

        <!-- Botones de acceso -->
        @auth
        <div class="space-y-4 flex flex-col items-center">
            <form method="GET" action="{{ route('dashboard') }}">
                @csrf
                <x-secondary-button type="submit" class="border-2 border-accent shadow hover:bg-accent hover:text-primary-light text-primary-dark font-bold py-3 px-8 transition duration-300 mb-8 w-full text-base md:text-lg">
                    Entrar
                </x-secondary-button>
            </form>
        </div>
        @else
        <div class="space-y-4 flex flex-col items-center">
            <a href="{{ route('login') }}" class="block bg-accent hover:opacity-70 text-primary-light font-bold py-3 px-5 transition duration-200 text-center w-2/3 text-base md:text-lg">
                Iniciar sesión
            </a>
            <p class="inline-block hover:text-primary-dark text-sm">
                ¿Eres nuevo?
                <span class="text-accent hover:underline"><a href="{{ route('register') }}">Regístrate</a></span>
            </p>
        </div>
        @endauth
    </div>
</div>
@endsection