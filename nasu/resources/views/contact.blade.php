@extends('layouts.app')

@section('title', 'Contacta con nosotros')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-4">
        <h1 class="font-title text-gray-900">Contacta con nosotros</h1>
    </div>
    <div class="page shadow rounded-lg overflow-hidden">
        <div class="grid md:grid-cols-2">
            <!-- Contact Form -->
            <div class="sm:p-8">
                <form action="" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-body font-medium text-gray-700">Nombre</label>
                            <x-text-input type="text" id="name" name="name" required
                                class="mt-1 block w-full" />
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-body font-medium text-gray-700">Correo</label>
                            <x-text-input type="email" id="email" name="email" required
                                class="mt-1 block w-full" />
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-body font-medium text-gray-700">Mensaje</label>
                            <x-textarea
                                id="message"
                                name="message"
                                class="block w-full"
                                rows="4"
                                placeholder=" "
                                required></x-textarea>
                        </div>

                        <div class="pt-2 flex justify-center">
                            <x-primary-button type="submit"
                                class="">
                                Enviar
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="sm:p-8">
                <div class="mt-4 space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm text-gray-500">
                            <p>Envianos un correo</p>
                            <p class="font-medium text-gray-900">support@roomdesignapp.com</p>
                        </div>
                    </div>

                    <div class="flex items-start ">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm text-gray-500">
                            <p>Llámanos</p>
                            <p class="font-medium text-gray-900">+1 (555) 123-4567</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm text-gray-500">
                            <p>Visita nuestra oficina</p>
                            <p class="font-medium text-gray-900">123 Design Street<br>Creative City, CC 10001</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection