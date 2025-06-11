<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            {{ __('Mis Reservas') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-cover bg-center bg-no-repeat shadow rounded-lg p-6 " 
      style="background-image: url('{{ asset('downloads/img_blue.webp') }}');">>
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

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 leading-relaxed opacity-60 ">
                <div class="flex justify-between items-center mb-6 backdrop-blur-sm">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Reservas Futuras
                    </h3>
                    
                    @if($reservas->count() < 5)
                        <a href="{{ route('reservas.create') }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Nueva Reserva
                        </a>
                    @else
                        <span class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed" 
                              title="Has alcanzado el límite de 5 reservas futuras">
                            Nueva Reserva
                        </span>
                    @endif
                </div>

               <div class="overflow-y-auto overflow-x-auto flex justify-center leading-relaxed opacity-100">
                    <table class="table-auto lg:min-w-[80%] divide-y divide-gray-200 dark:divide-gray-700 text-sm text-center">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                            <tr>
                                <th class="px-4 py-2">Autocaravana</th>
                                <th class="px-4 py-2">Fecha Inicio</th>
                                <th class="px-4 py-2">Fecha Fin</th>
                                <th class="px-4 py-2">Días</th>
                                <th class="px-4 py-2">Precio Total</th>
                                <th class="px-4 py-2">Estado Pago</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 text-gray-700 dark:text-gray-300 dark:divide-gray-700">
                            @forelse($reservas as $reserva)
                                <tr>
                                    <td class="px-4 py-2">
                                        <div class="font-medium">{{ $reserva->autocaravana->modelo ?? 'Desconocido' }}</div>
                                        <div class="text-sm text-gray-500">{{ $reserva->autocaravana->matricula ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reserva->fecha_inicio)->diffInDays($reserva->fecha_fin) }}</td>
                                    <td class="px-4 py-2">{{ number_format($reserva->precio_total, 2) }} €</td>
                                    <td class="px-4 py-2">
                                        @if($reserva->pago_realizado)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Pagado</span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pendiente</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <a href="{{ route('reservas.edit', $reserva->id) }}"
                                           class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                            Editar
                                        </a>

                                        <form method="POST" action="{{ route('reservas.destroy', $reserva->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm"
                                                    onclick="return confirm('¿Seguro que quieres eliminar esta reserva?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No tienes reservas futuras.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Sección de reservas pasadas (opcional) -->
                @if($reservasPasadas->count() > 0)
                    <div class="mt-12">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Reservas Pasadas
                        </h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                                    <tr>
                                        <th class="px-4 py-2">Autocaravana</th>
                                        <th class="px-4 py-2">Fecha Inicio</th>
                                        <th class="px-4 py-2">Fecha Fin</th>
                                        <th class="px-4 py-2">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 text-gray-700 dark:text-gray-300 dark:divide-gray-700">
                                    @foreach($reservasPasadas as $reserva)
                                        <tr class="opacity-70">
                                            <td class="px-4 py-2">{{ $reserva->autocaravana->modelo ?? 'Desconocido' }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Completada</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>