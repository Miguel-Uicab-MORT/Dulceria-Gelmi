<div class="container p-3 mx-auto">

    <div class="p-3 mb-3 bg-white rounded-lg shadow-lg">
        <div class="items-center block p-3 sm:flex">
            <div class="flex items-center flex-1">
                <x-jet-input class="flex-1" wire:model="search" type="text" placeholder="Buscar producto" required
                    autofocus />
            </div>
            @can('product.create')
                <div class="flex justify-center mt-1 sm:ml-1 sm:mt-0">
                    @livewire('components.create-product')
                </div>
            @endcan
        </div>
        <section x-data="{ type_search: @entangle('type_search') }">
            <div class="flex items-center ">
                <div>
                    <label class="ml-2">
                        <input value="1" type="radio" x-model="type_search" name="type_search">
                        <span class="mr-2">
                            {{ __('ID') }}
                        </span>
                    </label>
                    <label class="ml-2">
                        <input value="2" type="radio" x-model="type_search" name="type_search">
                        <span class="ml-2">
                            {{ __('Código de barras') }}
                        </span>
                    </label>
                    <label class="ml-2">
                        <input value="3" type="radio" x-model="type_search" name="type_search">
                        <span class="ml-2">
                            {{ __('Nombre') }}
                        </span>
                    </label>
                </div>
            </div>
        </section>
    </div>

    <div>
        <table class="w-full tables">
            <thead>
                <th></th>
                <th>CODIGOS</th>
                <th>NOMBRE</th>
                <th>ESTADO</th>
                <th>EXISTENCIA</th>
                <th>PRECIO</th>
                <th></th>
            </thead>

            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td class="text-center">
                            {{ $producto->id }}
                        </td>
                        <td class="text-center">
                            {{ $producto->barcode }}
                        </td>
                        <td>
                            {{ $producto->name }}
                        </td>
                        <td class="text-center">
                            @switch($producto->status)
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
                        <td class="text-center">
                            {{ $producto->stock }}
                        </td>
                        <td class="font-bold text-center">
                            <b>$</b>{{ number_format($producto->price, 2, '.', ',') }}
                        </td>
                        <td class="flex justify-end">
                            @can('product.edit')
                                <x-jet-secondary-button class="ml-1" wire:click='edit({{ $producto }})'>
                                    <i class="text-xl fas fa-edit"></i>
                                </x-jet-secondary-button>
                            @endcan
                            @can('product.delete')
                                <x-jet-danger-button class="ml-1" wire:click="$emit('destroy', {{ $producto->id }})">
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
                            {{ $productos->links() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <x-jet-dialog-modal wire:model='edit'>

        <x-slot name="title">
            Editar producto
        </x-slot>
        <x-slot name="content">
            {!! Form::open() !!}
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <x-jet-label>Nombre del producto:</x-jet-label>
                    {!! Form::text('ename', null, ['wire:model' => 'producto.name', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="producto.name"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Clave del producto:</x-jet-label>
                    {!! Form::select('ekey_product', $keys_products, null, ['wire:model' => 'producto.key_product', 'placeholder' => 'Elija una opción', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="producto.key_product"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Costo:</x-jet-label>
                    {!! Form::number('ecost', null, ['wire:model' => 'producto.cost', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="producto.cost"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Precio:</x-jet-label>
                    {!! Form::number('eprice', null, ['wire:model' => 'producto.price', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="producto.price"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>En existencia:</x-jet-label>
                    {!! Form::number('estock', null, ['wire:model' => 'producto.stock', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="producto.stock"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Estatus:</x-jet-label>
                    {!! Form::select('estatus', $statusList, null, ['wire:model' => 'producto.status', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="producto.status"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Codigo de barras:</x-jet-label>
                    {!! Form::number('ebarcode', null, ['wire:model' => 'producto.barcode', 'class' => 'form-input', 'disabled']) !!}
                    <x-jet-input-error for="producto.barcode"></x-jet-input-error>
                </div>
                @if ($barcode != null)
                    @if (strlen($barcode) == 8)
                        <div class="flex items-center justify-center">
                            {!! DNS1D::getBarcodeHTML($barcode, 'EAN8') !!}
                        </div>
                    @elseif (strlen($barcode) == 13)
                        <div class="flex items-center justify-center">
                            {!! DNS1D::getBarcodeHTML($barcode, 'EAN13') !!}
                        </div>
                    @elseif (strlen($barcode) == 12)
                        <div class="flex items-center justify-center">
                            {!! DNS1D::getBarcodeHTML($barcode, 'UPCA') !!}
                        </div>
                    @endif
                @endif

            </div>
            {!! Form::close() !!}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="mr-3" wire:click='edit({{ $producto }})'>
                Cancelar
            </x-jet-secondary-button>
            @can('product.update')
                <x-jet-button wire:click='update'>
                    Actualizar
                </x-jet-button>
            @endcan
        </x-slot>

    </x-jet-dialog-modal>

    @push('js')
        <script>
            Livewire.on('alert', function(message) {
                Swal.fire(
                    'Acción exitosa',
                    message,
                    'success'
                )
            })
        </script>
        <script>
            Livewire.on('destroy', item => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, bórralo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('inventory', 'delete', item)
                        Swal.fire(
                            '¡Eliminado!',
                            'Su archivo ha sido eliminado.',
                            'success'
                        )
                    }
                })
            })
        </script>
    @endpush
</div>
