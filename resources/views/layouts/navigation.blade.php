<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="h-10 w-auto fill-current text-gray-600 dark:text-gray-300" />
                </a>
            </div>

            <!-- Menú Desktop -->
            <div class="hidden sm:flex sm:items-center space-x-8">
                @auth
                    @if(auth()->user()->rol === 'admin')
                        <x-nav-link href="{{ route('admin.autocaravanas') }}" :active="request()->routeIs('admin.*')">
                            Panel Admin
                        </x-nav-link>
                    @else
                        <x-nav-link href="{{ route('reservas.index') }}" :active="request()->routeIs('reservas.*')">
                            Mis Reservas
                        </x-nav-link>
                    @endif
                    
                    <!-- User Dropdown -->
                    <x-dropdown alignment="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                {{ Auth::user()->name }}
                                <x-heroicon-s-chevron-down class="ml-1 h-4 w-4" />
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    Cerrar Sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>
        </div>
    </div>
</nav>