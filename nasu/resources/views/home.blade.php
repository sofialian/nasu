@extends('layouts.app')
@section('content')
<div class="flex-grow flex items-center justify-center h-screen flex flex-col bg-primary-light">

    <!-- Colores tailwind -->
    <!-- <div class="flex items-center justify-center w-full mx-auto border-2 border-primary-dark rounded-lg text-xs">
        <div class="grid grid-cols-2 gap-2 p-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            <div class="bg-slate-500 text-white h-10 w-10 flex items-center justify-center rounded">slate</div>
            <div class="bg-gray-500 text-white h-10 w-10 flex items-center justify-center rounded">gray</div>
            <div class="bg-zinc-500 text-white h-10 w-10 flex items-center justify-center rounded">zinc</div>
            <div class="bg-neutral-500 text-white h-10 w-10 flex items-center justify-center rounded">neutral</div>
            <div class="bg-stone-500 text-white h-10 w-10 flex items-center justify-center rounded">stone</div>
            <div class="bg-red-500 text-white h-10 w-10 flex items-center justify-center rounded">red</div>
            <div class="bg-orange-500 text-white h-10 w-10 flex items-center justify-center rounded">orange</div>
            <div class="bg-amber-500 text-white h-10 w-10 flex items-center justify-center rounded">amber</div>
            <div class="bg-yellow-500 text-black h-10 w-10 flex items-center justify-center rounded">yellow</div>
            <div class="bg-lime-500 text-black h-10 w-10 flex items-center justify-center rounded">lime</div>
            <div class="bg-green-500 text-white h-10 w-10 flex items-center justify-center rounded">green</div>
            <div class="bg-emerald-500 text-white h-10 w-10 flex items-center justify-center rounded">emerald</div>
            <div class="bg-teal-500 text-white h-10 w-10 flex items-center justify-center rounded">teal</div>
            <div class="bg-cyan-500 text-white h-10 w-10 flex items-center justify-center rounded">cyan</div>
            <div class="bg-sky-500 text-white h-10 w-10 flex items-center justify-center rounded">sky</div>
            <div class="bg-blue-500 text-white h-10 w-10 flex items-center justify-center rounded">blue</div>
            <div class="bg-indigo-500 text-white h-10 w-10 flex items-center justify-center rounded">indigo</div>
            <div class="bg-violet-500 text-white h-10 w-10 flex items-center justify-center rounded">violet</div>
            <div class="bg-purple-500 text-white h-10 w-10 flex items-center justify-center rounded">purple</div>
            <div class="bg-fuchsia-500 text-white h-10 w-10 flex items-center justify-center rounded">fuchsia</div>
            <div class="bg-pink-500 text-white h-10 w-10 flex items-center justify-center rounded">pink</div>
            <div class="bg-rose-500 text-white h-10 w-10 flex items-center justify-center rounded">rose</div>
        </div> -->

        <div class="grid grid-cols-2 gap-3 p-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 hidden">
            <!-- Grises -->
            <div class="border-2 border-slate-500 bg-slate-100 text-slate-500 h-10 w-10 flex items-center justify-center rounded-lg">slate</div>
            <div class="border-2 border-gray-500 bg-gray-100 text-gray-500 h-10 w-10 flex items-center justify-center rounded-lg">gray</div>
            <div class="border-2 border-zinc-500 bg-zinc-100 text-zinc-500 h-10 w-10 flex items-center justify-center rounded-lg">zinc</div>
            <div class="border-2 border-neutral-500 bg-neutral-100 text-neutral-500 h-10 w-10 flex items-center justify-center rounded-lg">neutral</div>
            <div class="border-2 border-stone-500 bg-stone-100 text-stone-500 h-10 w-10 flex items-center justify-center rounded-lg">stone</div>

            <!-- Colores cálidos -->
            <div class="border-2 border-red-500 bg-red-100 text-red-500 h-10 w-10 flex items-center justify-center rounded-lg">red</div>
            <div class="border-2 border-orange-500 bg-orange-100 text-orange-500 h-10 w-10 flex items-center justify-center rounded-lg">orange</div>
            <div class="border-2 border-amber-500 bg-amber-100 text-amber-500 h-10 w-10 flex items-center justify-center rounded-lg">amber</div>
            <div class="border-2 border-yellow-500 bg-yellow-100 text-yellow-500 h-10 w-10 flex items-center justify-center rounded-lg">yellow</div>

            <!-- Verdes -->
            <div class="border-2 border-lime-500 bg-lime-100 text-lime-500 h-10 w-10 flex items-center justify-center rounded-lg">lime</div>
            <div class="border-2 border-green-500 bg-green-100 text-green-500 h-10 w-10 flex items-center justify-center rounded-lg">green</div>
            <div class="border-2 border-emerald-500 bg-emerald-100 text-emerald-500 h-10 w-10 flex items-center justify-center rounded-lg">emerald</div>

            <!-- Azules -->
            <div class="border-2 border-teal-500 bg-teal-100 text-teal-500 h-10 w-10 flex items-center justify-center rounded-lg">teal</div>
            <div class="border-2 border-cyan-500 bg-cyan-100 text-cyan-500 h-10 w-10 flex items-center justify-center rounded-lg">cyan</div>
            <div class="border-2 border-sky-500 bg-sky-100 text-sky-500 h-10 w-10 flex items-center justify-center rounded-lg">sky</div>
            <div class="border-2 border-blue-500 bg-blue-100 text-blue-500 h-10 w-10 flex items-center justify-center rounded-lg">blue</div>

            <!-- Púrpuras -->
            <div class="border-2 border-indigo-500 bg-indigo-100 text-indigo-500 h-10 w-10 flex items-center justify-center rounded-lg">indigo</div>
            <div class="border-2 border-violet-500 bg-violet-100 text-violet-500 h-10 w-10 flex items-center justify-center rounded-lg">violet</div>
            <div class="border-2 border-purple-500 bg-purple-100 text-purple-500 h-10 w-10 flex items-center justify-center rounded-lg">purple</div>
            <div class="border-2 border-fuchsia-500 bg-fuchsia-100 text-fuchsia-500 h-10 w-10 flex items-center justify-center rounded-lg">fuchsia</div>

            <!-- Rosas -->
            <div class="border-2 border-pink-500 bg-pink-100 text-pink-500 h-10 w-10 flex items-center justify-center rounded-lg">pink</div>
            <div class="border-2 border-rose-500 bg-rose-100 text-rose-500 h-10 w-10 flex items-center justify-center rounded-lg">rose</div>
        </div>

        <!-- Colores del proyecto -->
        <div class="grid grid-cols-2 gap-3 p-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 hidden">
            <div class="border-2 bg-[#474350] text-primary-light h-10 w-14 flex items-center justify-center rounded-lg">primary-dark</div>
            <div class="border-2 border-primary-dark bg-[#FCFFEB] text-primary-dark h-10 w-14 flex items-center justify-center rounded-lg">primary-light</div>
            <div class="border-2 border-accent bg-[#FF4E4E] text-primary-light h-10 w-14 flex items-center justify-center rounded-lg">accent</div>
            <div class="border-2 border-accent-dark bg-[#97D5CA] text-primary-dark h-10 w-14 flex items-center justify-center rounded-lg">sec-accent</div>

        </div>

        <!-- Contenido principal centrado -->
        <div class="w-full max-w-md px-4 py-8 text-center">
            <!-- Animación del logo -->
            <div class="mb-8 animate-bounce mx-auto" style="width: fit-content;">
                <div class="h-10 w-10 w-10 w-10 border-3 border-secondary-color rounded-full flex items-center justify-center mx-auto text-secondary-color text-4xl font-logo">
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