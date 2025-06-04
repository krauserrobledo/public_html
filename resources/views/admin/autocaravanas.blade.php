<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            {{ __('Gestión de Autocaravanas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <!-- Barra de acciones -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Todas las Autocaravanas
                    </h3>
                    <a href="{{ route('admin.autocaravanas.create') }}" >
                    <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Añadir Nueva
                    </button>
                    </a>
                </div>

                <!-- Listado -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Modelo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Detalles</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($autocaravanas as $autocaravana)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $autocaravana['modelo'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 dark:text-white">
                                        {{ $autocaravana['plazas'] }} plazas
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $autocaravana['precio_por_dia'] }}€/día
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $autocaravana['disponible'] 
                                            ? 'bg-green-100 text-white' 
                                            : 'bg-red-100 text-red-800' }}">
                                        {{ $autocaravana['disponible'] ? 'Disponible' : 'En mantenimiento' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                <a href="{{ route('admin.autocaravanas.edit', $autocaravana->id) }}">
                                    <button class="px-2 py-1 text-xs rounded-full bg-white dark:bg-gray-800 divide-y divide-gray-200 border text-gray-300 dark:text-gray-300 dark:divide-gray-700">
                                        Editar
                                    </button>
                                </a>
                                    <form action="{{ route('admin.autocaravanas.destroy', $autocaravana->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta autocaravana?')"
                                    class="px-2 py-1 text-xs rounded-full bg-white dark:bg-gray-800 text-red-600 hover:text-red-900 border border-red-300">
                                    Eliminar
                                </button>
                            </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>