<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            {{ __('Autocaravanas Disponibles') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-cover bg-center bg-no-repeat shadow rounded-lg p-6" 
         style="background-image: url('{{ asset('downloads/caravanas.webp') }}');">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="text-white p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-700 border-l-4 border-red-700 text-red-700 p-4 mb-6" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 leading-relaxed opacity-90">
                <div class="flex justify-between items-center mb-6 backdrop-blur-sm">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Nuestras Autocaravanas
                    </h3>

                    <a href="{{ route('reservas.index') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Mis Reservas
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($autocaravanas as $auto)
                        <div class="border rounded-lg p-6 bg-white dark:bg-gray-700 shadow-md hover:shadow-lg transition duration-300 opacity-95">
                                                        
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $auto->modelo }}</h3>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ Str::limit($auto->descripcion, 100) }}</p>
                            
                            <div class="grid grid-cols-2 gap-2 text-sm mb-4">
                                <div class="bg-gray-100 dark:bg-gray-600 p-2 rounded">
                                    <span class="font-medium">Plazas:</span> {{ $auto->plazas }}
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                    {{ $auto->precio_por_dia }} €/día
                                </span>
                                
                                <a href="{{ route('reservas.create', ['autocaravana_id' => $auto->id]) }}" 
                                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    Reservar
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 text-lg">
                                No hay autocaravanas disponibles en este momento.
                            </p>
                            <a href="{{ route('reservas.index') }}" 
                               class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Volver al inicio
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>