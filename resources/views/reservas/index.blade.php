<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            {{ __('Mis Reservas') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-cover bg-center bg-no-repeat shadow rounded-lg p-6" 
         style="background-image: url('{{ asset('downloads/img_blue.webp') }}');">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes flash mejorados -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Contenedor principal con mejor contraste -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 backdrop-blur-sm">
                <!-- Encabezado con mejor espaciado -->
                <div class="flex flex-col sm:flex-row  items-start sm:items-center gap-4 mb-8">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Mis Reservas Activas
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Gestiona tus reservas actuales y futuras
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('reservas.autocaravanas') }}" 
                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1V5a1 1 0 00-1-1H3zM3 5h2v2H3V5zm4 0h2v2H7V5zm4 0h2v2h-2V5zm4 0h2v2h-2V5zm3 3H4v6h14V8z" />
                            </svg>
                            Ver Autocaravanas
                        </a>
                        
                        @if($reservas->count() < 5)
                            <a href="{{ route('reservas.create') }}" 
                               class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                                Nueva Reserva
                            </a>
                        @else
                            <span class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed flex items-center gap-2" 
                                  title="Has alcanzado el límite de 5 reservas futuras">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                                Límite Alcanzado
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Tabla principal con mejor diseño -->
                <div class="overflow-y-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Autocaravana</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fechas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duración</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Precio</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($reservas as $reserva)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($reserva->autocaravana->imagen ?? false)
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $reserva->autocaravana->imagen) }}" alt="{{ $reserva->autocaravana->modelo ?? 'Autocaravana' }}">
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $reserva->autocaravana->modelo ?? 'Desconocido' }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $reserva->autocaravana->plazas ?? '--' }} plazas
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->isoFormat('D MMM YYYY') }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            al {{ \Carbon\Carbon::parse($reserva->fecha_fin)->isoFormat('D MMM YYYY') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->diffInDays($reserva->fecha_fin) }} días
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $reserva->autocaravana->precio_por_dia ?? '--' }} €/día
                                        </div>
                                        <div class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                            {{ number_format(\Carbon\Carbon::parse($reserva->fecha_inicio)->diffInDays($reserva->fecha_fin) * ($reserva->autocaravana->precio_por_dia ?? 0), 2) }} €
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($reserva->pago_realizado)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Pagado
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('reservas.edit', $reserva->id) }}"
                                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition flex items-center"
                                               title="Editar reserva">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>

                                            <form method="POST" action="{{ route('reservas.destroy', $reserva->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition flex items-center"
                                                        title="Eliminar reserva"
                                                        onclick="return confirm('¿Seguro que quieres eliminar esta reserva?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No tienes reservas futuras</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza reservando una autocaravana disponible</p>
                                        <div class="mt-6">
                                            <a href="{{ route('reservas.autocaravanas') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Ver autocaravanas
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>