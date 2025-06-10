<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">
                    Bienvenido, Administrador 👋
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Botón de Autocaravanas -->
                    <a href="{{ route('admin.autocaravanas.index') }}" class="block p-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition duration-200">
                        <h4 class="text-lg font-semibold mb-2">Gestionar Autocaravanas</h4>
                        <p>Visualiza, edita o elimina autocaravanas disponibles en el sistema.</p>
                    </a>

                    <!-- Botón de Reservas -->
                    <a href="{{ route('admin.reservas.index') }}" class="block p-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition duration-200">
                        <h4 class="text-lg font-semibold mb-2">Gestionar Reservas</h4>
                        <p>Consulta todas las reservas realizadas por los clientes y gestiona su estado.</p>
                    </a>

                    <!-- Crear Reserva -->
                    <a href="{{ route('admin.reservas.create') }}" class="block p-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition duration-200">
                        <h4 class="text-lg font-semibold mb-2">Crear Reserva</h4>
                        <p>Haz una reserva en nombre de un cliente.</p>
                    </a>

                    <a href="{{ route('admin.historial.index') }}" class="block p-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition duration-200">
                        <h4 class="text-lg font-semibold mb-2">Ver Historial</h4>
                        <p>Comprueba reservas ya pasadas.</p>
                    </a>

                    <!-- Enlace adicional si lo deseas -->
                    <a href="{{ route('logout') }}" class="block p-6 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow transition duration-200"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <h4 class="text-lg font-semibold mb-2">Cerrar Sesión</h4>
                        <p>Salir del panel de administración.</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
