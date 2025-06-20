@extends('layouts.app')

@section('title', 'Sobre Nasu')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-8">
        <h1 class="font-bold font-title text-primary-dark">Sobre Nasu</h1>
    </div>

    <div class="page shadow">
        <div class="prose max-w-none">
            <h2 class="text-xl font-semibold font-body text-primary-dark">Nuestra Misión</h2>
            <p class="text-gray-700">
                Ofrecemos soluciones innovadoras de diseño de interiores para ayudarte a visualizar y crear tu espacio perfecto.
            </p>

            <h2 class="mt-6 text-xl font-semibold font-body text-primary-dark">Características</h2>
            <ul class="space-y-4">
                <x-list-icon text="Editor de habitaciones interactivo" />
                <x-list-icon text="Amplio catálogo de muebles" />
                <x-list-icon text="Guarda y comparte tus diseños" />
            </ul>

            <h2 class="mt-6 text-xl font-semibold font-body text-primary-dark">El Equipo</h2>
            <p class="text-gray-700">
                Nuestro equipo de diseñadores y desarrolladores está comprometido en crear herramientas que hagan el diseño de interiores accesible para todos.
            </p>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-6">
            <p class="text-gray-700">¿Tienes preguntas? <a href="{{ route('contact') }}" class="text-accent hover:underline">Contáctanos</a></p>
        </div>
    </div>
</div>
@endsection