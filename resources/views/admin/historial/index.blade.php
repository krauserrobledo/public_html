<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            {{ __('Historial de Reservas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                            <tr>
                                <th class="px-4 py-2">Cliente</th>
                                <th class="px-4 py-2">Autocaravana</th>
                                <th class="px-4 py-2">Fecha Inicio</th>
                                <th class="px-4 py-2">Fecha Fin</th>
                                <th class="px-4 py-2">Pago Realizado</th>
                                <th class="px-4 py-2">Porcentaje Pagado</th>
                            </tr>
                        </thead>
                        <tbody class="px-4 py-2 text-gray-800 dark:text-gray-200">
                            @forelse($historial as $reserva)
                                <tr>
                                    <td class="px-4 py-2">{{ $reserva->id_usuario }}</td>
                                    <td class="px-4 py-2">{{ $reserva->id_autocaravana }}</td>
                                    <td class="px-4 py-2">{{ $reserva->fecha_inicio }}</td>
                                    <td class="px-4 py-2">{{ $reserva->fecha_fin }}</td>
                                    <td class="px-4 py-2">{{ $reserva->pago_realizado ? 'Sí' : 'No' }}</td>
                                    <td class="px-4 py-2">{{ $reserva->porcentaje_pagado ?? '0' }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-white">
                                        No hay reservas en el historial.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $historial->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
