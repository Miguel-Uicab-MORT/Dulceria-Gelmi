<div>
    <div class="container p-3 mx-auto">

        <div class="flex items-center p-3">
            <div class="flex items-center flex-1">
                <x-jet-input class="flex-1" wire:model="search" type="text" placeholder="Buscar producto"
                    required autofocus />
            </div>
            <div class="ml-2">
                @livewire('components.create-client')
            </div>
        </div>
        <section x-data="{ type_search: @entangle('type_search') }">
            <div class="flex items-center p-3 mb-3 bg-white rounded-lg shadow-lg">
                <div>
                    <label class="ml-2">
                        <input value="1" type="radio" x-model="type_search" name="type_search">
                        <span class="mr-2">
                            {{ __('Nombre') }}
                        </span>
                    </label>
                    <label class="ml-2">
                        <input value="2" type="radio" x-model="type_search" name="type_search">
                        <span class="ml-2">
                            {{ __('RFC') }}
                        </span>
                    </label>
                    <label class="ml-2">
                        <input value="3" type="radio" x-model="type_search" name="type_search">
                        <span class="ml-2">
                            {{ __('Número celular') }}
                        </span>
                    </label>
                    <label class="ml-2">
                        <input value="4" type="radio" x-model="type_search" name="type_search">
                        <span class="ml-2">
                            {{ __('Email') }}
                        </span>
                    </label>
                </div>
            </div>
        </section>

        <div>
            <table class="w-full tables">
                <thead>
                    <th>Nombre</th>
                    <th>Número</th>
                    <th>Email</th>
                    <th>RFC</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>
                                <div class="px-3">
                                    {{ $cliente->name . ' ' . $cliente->lastname }}
                                </div>
                            </td>
                            <td>
                                <div class="px-3">
                                    {{ $cliente->number }}
                                </div>
                            </td>
                            <td>
                                <div class="px-3">
                                    {{ $cliente->email }}
                                </div>
                            </td>
                            <td>
                                <div class="px-3">
                                    {{ $cliente->rfc }}
                                </div>
                            </td>
                            <td class="flex justify-end">
                                @can('product.edit')
                                    <x-jet-secondary-button class="ml-1" wire:click='edit({{ $cliente }})'>
                                        <i class="text-xl fas fa-edit"></i>
                                    </x-jet-secondary-button>
                                @endcan
                                @can('product.delete')
                                    <x-jet-danger-button class="ml-1" wire:click='delete({{ $cliente }})'>
                                        <i class="text-xl fas fa-trash"></i>
                                    </x-jet-danger-button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="9">
                            <div class="py-1 text-center">
                                {{ $clientes->links() }}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <x-jet-dialog-modal wire:model='edit'>

            <x-slot name="title">
                Editar Cliente
            </x-slot>
            <x-slot name="content">
                {!! Form::open() !!}
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <x-jet-label>Nombre del cliente:</x-jet-label>
                        {!! Form::text('name', null, ['wire:model' => 'cliente.name', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.name"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>Apellidos:</x-jet-label>
                        {!! Form::text('lastname', null, ['wire:model' => 'cliente.lastname', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.lastname"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>Razón Social:</x-jet-label>
                        {!! Form::text('businessname', null, ['wire:model' => 'cliente.businessname', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.businessname"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>Número:</x-jet-label>
                        {!! Form::text('number', null, ['wire:model' => 'cliente.number', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.number"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>Email:</x-jet-label>
                        {!! Form::email('email', null, ['wire:model' => 'cliente.email', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.email"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>Tipo de persona:</x-jet-label>
                        {!! Form::select('typePerson', $typePerson, null, ['wire:model' => 'cliente.typePerson', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.typePerson"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>RFC:</x-jet-label>
                        {!! Form::text('rfc', null, ['wire:model' => 'cliente.rfc', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.rfc"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>CP:</x-jet-label>
                        {!! Form::text('cp', null, ['wire:model' => 'cliente.cp', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.cp"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>Estado:</x-jet-label>
                        {!! Form::text('state', null, ['wire:model' => 'cliente.state', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.state"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>Ciudad/Municipio:</x-jet-label>
                        {!! Form::text('city', null, ['wire:model' => 'cliente.city', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.city"></x-jet-input-error>
                    </div>
                    <div>
                        <x-jet-label>Colonia:</x-jet-label>
                        {!! Form::text('colony', null, ['wire:model' => 'cliente.colony', 'class' => 'form-input']) !!}
                        <x-jet-input-error for="cliente.colony"></x-jet-input-error>
                    </div>
                </div>

                <div class="w-full mt-5">
                    <x-jet-label>Direccion:</x-jet-label>
                    {!! Form::text('cliente.address', null, ['wire:model' => 'cliente.address', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="cliente.address"></x-jet-input-error>
                </div>
                {!! Form::close() !!}
            </x-slot>
            <x-slot name="footer">
                <x-jet-secondary-button class="mr-3" wire:click='edit({{ $cliente }})'>
                    Cancelar
                </x-jet-secondary-button>
                    <x-jet-button wire:click='update'>
                        Actualizar
                    </x-jet-button>
            </x-slot>

        </x-jet-dialog-modal>

    </div>
</div>
