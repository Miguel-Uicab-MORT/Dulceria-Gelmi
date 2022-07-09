<div>
    <x-jet-button wire:click='create'>
        Añadir Producto
    </x-jet-button>

    <x-jet-dialog-modal wire:model='create'>

        <x-slot name="title">
            Editar Producto
        </x-slot>
        <x-slot name="content">
            {!! Form::open() !!}
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <x-jet-label>Nombre del producto:</x-jet-label>
                    {!! Form::text('name', null, ['wire:model' => 'name', 'class' => 'form-input', 'placeholder' => 'Nombre del producto', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="name"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Clave del producto:</x-jet-label>
                    {!! Form::select('key_product', $keys_products, null, ['wire:model' => 'key_product', 'placeholder' => 'Elija una opción', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="key_product"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Costo:</x-jet-label>
                    {!! Form::number('cost', null, ['wire:model' => 'cost', 'placeholder' => 'Precio del producto', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="cost"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Precio:</x-jet-label>
                    {!! Form::number('price', null, ['wire:model' => 'price', 'placeholder' => 'Precio del producto', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="price"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>En existencia:</x-jet-label>
                    {!! Form::number('stock', null, ['wire:model' => 'stock', 'placeholder' => 'Excistencia del producto', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="stock"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Estatus:</x-jet-label>
                    {!! Form::select('status', $statusList, null, ['wire:model' => 'status', 'placeholder' => 'Elija una opción', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="status"></x-jet-input-error>
                    <x-jet-input-error for="barcode"></x-jet-input-error>
                </div>
            </div>
            <div class="mt-5">
                <section x-data="{ exist_barcode: @entangle('exist_barcode') }" class="grid grid-cols-2 gap-5">
                    <div>
                        <x-jet-label>¿Ya tiene código de barras?:</x-jet-label>
                        <div class="flex items-center">
                            <label class="mr-2">
                                <input value="1" type="radio" x-model="exist_barcode" name="exist_barcode">
                                <span class="ml-2">
                                    {{ __('Si') }}
                                </span>
                            </label>
                            <label class="ml-2">
                                <input value="2" type="radio" x-model="exist_barcode" name="exist_barcode">
                                <span class="ml-2">
                                    {{ __('No') }}
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="hidden" :class="{ 'hidden': exist_barcode == 2 }">
                        <x-jet-label>Escriba el código de barras:</x-jet-label>
                        {!! Form::number('barcode', null, ['wire:model' => 'barcode', 'placeholder' => 'Escriba el código de barras', 'class' => 'form-input']) !!}
                    </div>
                </section>
            </div>

            {!! Form::close() !!}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="mr-3" wire:click='create'>
                Cancelar
            </x-jet-secondary-button>
            @can('product.store')
                <x-jet-button wire:click='store'>
                    Guardar
                </x-jet-button>
            @endcan

        </x-slot>

    </x-jet-dialog-modal>
</div>
