<div class="bg-gray-100">
    <div class="py-3">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <x-jet-button wire:click='listUsers'>Regresar a lista de empleados</x-jet-button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-5 lg:gap-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">
                    <div class="flex flex-col">

                        <h2 class=" text-center font-bold text-xl mb-3">
                            Lista de roles
                        </h2>

                        <div class="flex-grow overflow-auto">
                            {!! Form::model($user, ['route' => ['users.update.role', $user], 'method' => 'put']) !!}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($roles as $rol)
                                    <div class="grid grid-cols-1 ">
                                        <label>
                                            {!! Form::checkbox('roles[]', $rol->id, null, ['class' => 'mr-1 rounded']) !!}
                                            {{ $rol->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-center mt-5">
                                <x-jet-button>
                                    Asignar roles
                                </x-jet-button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">
                    <div class="flex flex-col">

                        <h2 class=" text-center font-bold text-xl mb-3">
                            Lista de permisos
                        </h2>

                        <div class="flex-grow overflow-auto">
                            {!! Form::model($user, ['route' => ['users.update.permission', $user], 'method' => 'put']) !!}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($permissions as $permission)
                                    <div class="">
                                        <div>
                                            <label>
                                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1 rounded']) !!}
                                                {{ $permission->description }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-center mt-5">
                                <x-jet-button>
                                    Asignar permisos
                                </x-jet-button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
