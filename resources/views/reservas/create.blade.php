<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            {{ $editando ? __('Editar Reserva') : __('Nueva Reserva') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    @php
                        $max_fecha_inicio = date('Y-m-d', strtotime('+60 days'));
                    @endphp
                <form method="POST" action="{{ $editando ? route('reservas.update', $reserva->id) : route('reservas.store') }}">
                    @csrf
                    @if($editando)
                        @method('PUT')
                    @endif

                    <!-- Selección de Autocaravana -->
                    <div class="mb-6">
                        <label for="id_autocaravana" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Autocaravana
                        </label>
                        <select id="id_autocaravana" name="id_autocaravana"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                required>
                            @foreach($autocaravanas as $autocaravana)
                                <option value="{{ $autocaravana->id }}"
                                    {{ old('id_autocaravana', $reserva->id_autocaravana ?? '') == $autocaravana->id ? 'selected' : '' }}>
                                    {{ $autocaravana->modelo }} ({{ $autocaravana->precio_por_dia }} €/día)
                                </option>
                            @endforeach
                        </select>
                        @error('id_autocaravana')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Fecha Inicio
                            </label>
                            <!-- Campo Fecha Inicio -->
                            <input id="fecha_inicio" name="fecha_inicio" type="date"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                value="{{ old('fecha_inicio', isset($reserva->fecha_inicio) ? $reserva->fecha_inicio->format('Y-m-d') : '') }}"
                                {{ !$editando ? 'min=' . date('Y-m-d') . ' max=' . $max_fecha_inicio : '' }} required>
                            @error('fecha_inicio')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Fecha Fin
                            </label>
                            <!-- Campo Fecha Fin -->
                            @php
                                $fecha_inicio_old = old('fecha_inicio');
                                $min_fecha_fin = $fecha_inicio_old
                                    ? date('Y-m-d', strtotime($fecha_inicio_old . ' +2 days'))
                                    : date('Y-m-d', strtotime('+2 days'));
                            @endphp

                            <input id="fecha_fin" name="fecha_fin" type="date"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                value="{{ old('fecha_fin', isset($reserva->fecha_fin) ? $reserva->fecha_fin->format('Y-m-d') : '') }}"
                                {{ !$editando ? 'min=' . $min_fecha_fin : '' }} required>
                            @error('fecha_fin')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Botones -->
                    <div class="flex items-center justify-end mt-6 space-x-4">
                        <a href="{{ route('reservas.index') }}"
                           class="px-4 py-2 bg-red-700 text-white rounded hover:bg-gray-600 transition shadow rounded-lg p-6">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-5 py-2 shadow rounded-lg p-6 bg-gray-500 text-white rounded hover:bg-blue-700 transition">
                            {{ $editando ? 'Actualizar' : 'Reservar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');

            function actualizarMinimoFechaFin() {
                if (fechaInicio.value) {
                    const minDate = new Date(fechaInicio.value);
                    minDate.setDate(minDate.getDate() + 2);
                    const minDateStr = minDate.toISOString().split('T')[0];
                    fechaFin.min = minDateStr;

                    if (fechaFin.value && new Date(fechaFin.value) < minDate) {
                        fechaFin.value = '';
                    }
                }
            }

            fechaInicio.addEventListener('change', actualizarMinimoFechaFin);

            // Ejecutar al cargar si hay valor inicial
            actualizarMinimoFechaFin();
        });
    </script>
    @endpush
</x-app-layout>
