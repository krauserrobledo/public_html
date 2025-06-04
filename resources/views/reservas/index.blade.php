<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            {{ __('Mis Reservas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-white p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Reservas Activas
                    </h3>
                    <a href="{{ route('reservas.create') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Nueva Reserva
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                            <tr>
                                <th class="px-4 py-2">Autocaravana</th>
                                <th class="px-4 py-2">Fecha Inicio</th>
                                <th class="px-4 py-2">Fecha Fin</th>
                                <th class="px-4 py-2">Pago Realizado</th>
                                <th class="px-4 py-2">Porcentaje Pagado</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 text-gray-300 dark:text-gray-300 dark:divide-gray-700">
                            @forelse($reservas as $reserva)
                                <tr>
                                    <td class="px-4 py-2">{{ $reserva->autocaravana->modelo ?? 'Desconocido' }}</td>
                                    <td class="px-4 py-2">{{ $reserva->fecha_inicio }}</td>
                                    <td class="px-4 py-2">{{ $reserva->fecha_fin }}</td>
                                    <td class="px-4 py-2">
                                        {{ $reserva->pago_realizado ? 'Sí' : 'No' }}
                                    </td>
                                    <td class="px-4 py-2">{{ $reserva->porcentaje_pagado ?? '0' }}%</td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <a href="{{ route('reservas.edit', $reserva->id) }}"
                                           class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>

                                        <form method="POST" action="{{ route('reservas.destroy', $reserva->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                                    onclick="return confirm('¿Seguro que quieres eliminar esta reserva?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No tienes reservas activas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación si la colección está paginada -->
                @if(method_exists($reservas, 'links'))
                    <div class="mt-4">
                        {{ $reservas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>