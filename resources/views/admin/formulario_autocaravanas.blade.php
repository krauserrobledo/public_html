<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            {{ isset($autocaravana) ? 'Editar Autocaravana' : 'Nueva Autocaravana' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            @if(isset($autocaravana))
                <form action="{{ route('admin.autocaravanas.update', $autocaravana->id) }}" method="POST">
                
                    @method('PUT')
            @else
                <form action="{{ route('admin.autocaravanas.store') }}" method="POST">
            @endif
                    @csrf

                    <!-- Modelo -->
                    <div class="mb-4">
                        <label for="modelo" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Modelo</label>
                        <input 
                            type="text" 
                            name="modelo" 
                            id="modelo" 
                            value="{{ old('modelo', $autocaravana->modelo ?? '') }}" 
                            class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2"
                            required
                        >
                        @error('modelo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Descripción</label>
                        <input 
                            type="text" 
                            name="descripcion" 
                            id="descripcion" 
                            value="{{ old('descripcion', $autocaravana->descripcion ?? '') }}" 
                            class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2"
                            required
                        >
                        @error('descripcion')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Plazas -->
                    <div class="mb-4">
                        <label for="plazas" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Número de plazas</label>
                        <input 
                            type="number" 
                            name="plazas" 
                            id="plazas" 
                            value="{{ old('plazas', $autocaravana->plazas ?? '') }}" 
                            min="1" 
                            class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2"
                            required
                        >
                        @error('plazas')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Precio por día -->
                    <div class="mb-4">
                        <label for="precio_por_dia" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Precio por día (€)</label>
                        <input 
                            type="number" 
                            name="precio_por_dia" 
                            id="precio_por_dia" 
                            value="{{ old('precio_por_dia', $autocaravana->precio_por_dia ?? '') }}" 
                            min="0" step="0.01" 
                            class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2"
                            required
                        >
                        @error('precio_por_dia')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Disponible -->
                    <div class="mb-6">
                        <label for="disponible" class="inline-flex items-center text-gray-700 dark:text-gray-300 font-medium">
                            <input 
                                type="checkbox" 
                                name="disponible" 
                                id="disponible" 
                                class="rounded text-green-600" 
                                {{ old('disponible', $autocaravana->disponible ?? false) ? 'checked' : '' }}
                            >
                            <span class="ml-2">Disponible</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-4">
                        <a href="{{ route('admin.autocaravanas.index') }}" 
                        class="px-4 py-2 bg-red-700 text-white rounded hover:bg-gray-600 transition shadow rounded-lg p-6">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2 shadow rounded-lg p-6 bg-gray-500 text-white rounded hover:bg-blue-700 transition">
                            {{ isset($autocaravana) ? 'Actualizar' : 'Crear' }}
                        </button>
                    </div>
                </form>
        </div>
    </div>
</x-app-layout>
