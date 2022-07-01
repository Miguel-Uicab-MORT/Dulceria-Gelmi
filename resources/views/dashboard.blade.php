<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Bienvenido, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 gap-1 mt-6 sm:grid-cols-2 lg:grid-cols-4 sm:gap-3 lg:gap-6">
        @can('category.index')
            <a href="{{ route('category.index') }}">
                <div class="p-3 bg-white rounded-lg shadow-xl hover:bg-gray-300">
                    <div class="flex justify-center">
                        <img src="/img/6.png" class="object-cover w-40" alt="">
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold leading-tight text-center text-gray-800">
                            Categorias
                        </h1>
                    </div>
                </div>
            </a>
        @endcan
        @can('inventory.index')
            <a href="{{ route('inventory.index') }}">
                <div class="p-3 bg-white rounded-lg shadow-xl hover:bg-gray-300">
                    <div class="flex justify-center">
                        <img src="/img/1.png" class="object-cover w-40" alt="">
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold leading-tight text-center text-gray-800">
                            Inventario
                        </h1>
                    </div>
                </div>
            </a>
        @endcan
        @can('pointsale.create')
            <a href="{{ route('pointsale.create') }}">
                <div class="p-3 bg-white rounded-lg shadow-xl hover:bg-gray-300">
                    <div class="flex justify-center">
                        <img src="/img/2.png" class="object-cover w-40" alt="">
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold leading-tight text-center text-gray-800">
                            Punto de venta
                        </h1>
                    </div>
                </div>
            </a>
        @endcan
            <a href="{{ route('client.index') }}">
                <div class="p-3 bg-white rounded-lg shadow-xl hover:bg-gray-300">
                    <div class="flex justify-center">
                        <img src="/img/clients.png" class="object-cover w-40" alt="">
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold leading-tight text-center text-gray-800">
                            Clientes
                        </h1>
                    </div>
                </div>
            </a>
        @can('reports.index')
            <a href="{{ route('reports.index') }}">
                <div class="p-3 bg-white rounded-lg shadow-xl hover:bg-gray-300">
                    <div class="flex justify-center">
                        <img src="/img/3.png" class="object-cover w-40" alt="">
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold leading-tight text-center text-gray-800">
                            Ventas
                        </h1>
                    </div>
                </div>
            </a>
        @endcan
        @can('users.index')
            <a href="{{ route('users.index') }}">
                <div class="p-3 bg-white rounded-lg shadow-xl hover:bg-gray-300">
                    <div class="flex justify-center">
                        <img src="/img/4.png" class="object-cover w-40" alt="">
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold leading-tight text-center text-gray-800">
                            Empleados
                        </h1>
                    </div>
                </div>
            </a>
        @endcan
        @can('roles.index')
            <a href="{{ route('roles.index') }}">
                <div class="p-3 bg-white rounded-lg shadow-xl hover:bg-gray-300">
                    <div class="flex justify-center">
                        <img src="/img/5.png" class="object-cover w-40" alt="">
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold leading-tight text-center text-gray-800">
                            Roles
                        </h1>
                    </div>
                </div>
            </a>
        @endcan

        <div>
            <x-btn-logout>Salir</x-btn-logout>
        </div>
    </div>
</x-app-layout>
