<div class="p-3">

    <div class="flex items-center p-3">
        <div class="flex items-center flex-1">
            <x-jet-input class="flex-1" wire:model="search" type="text" placeholder="Buscar producto" required
                autofocus />
        </div>
        @can('category.create')
            <div class="ml-2">
                @livewire('components.create-categoria')
            </div>
        @endcan
    </div>

    <div>
        <table class="w-full tables">
            <thead>
                <th>NOMBRE</th>
                <th>ESTADO</th>
                <th></th>
            </thead>

            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <td class="text-center">
                            {{ $categoria->name }}
                        </td>
                        <td class="text-center">
                            @switch($categoria->status)
                                @case(1)
                                    <span
                                        class="inline-flex px-2 text-xs font-semibold leading-5 text-white bg-green-500 rounded-full">
                                        Activo
                                    </span>
                                @break

                                @case(2)
                                    <span
                                        class="inline-flex px-2 text-xs font-semibold leading-5 text-white bg-red-800 rounded-full">
                                        Inactivo
                                    </span>
                                @break

                                @default
                            @endswitch

                        </td>
                        <td class="flex justify-end">
                            @can('category.edit')
                                <x-jet-secondary-button wire:click='edit({{ $categoria }})'>
                                    Editar
                                </x-jet-secondary-button>
                            @endcan
                            @can('category.delete')
                                <x-jet-danger-button class="ml-1" wire:click='delete({{ $categoria }})'>
                                    Borrar
                                </x-jet-danger-button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="py-1 text-center">
                            {{ $categorias->links() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <x-jet-dialog-modal wire:model='edit'>
        <x-slot name="title">
            Editar Categoria
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <x-jet-label>Nombre de la categoria:</x-jet-label>
                    {!! Form::text('name', null, ['wire:model' => 'categoria.name', 'placeholder' => 'Nombre del producto', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="name"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Estatus:</x-jet-label>
                    {!! Form::select('status', $statusList, null, ['wire:model' => 'categoria.status', 'placeholder' => 'Elija una opción', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="status"></x-jet-input-error>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="mr-3" wire:click='edit'>
                Cancelar
            </x-jet-secondary-button>
            @can('category.update')
                <x-jet-button wire:click='update'>
                    Guardar
                </x-jet-button>
            @endcan
        </x-slot>

    </x-jet-dialog-modal>

</div>
