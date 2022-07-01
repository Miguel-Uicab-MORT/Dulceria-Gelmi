<div class="p-3">
    <div class="flex items-center p-3">

        <div class="mr-2">
            <label class="mr-1">Cantidad:</label>
            <x-jet-input class="w-20" type="number" wire:model='qty'></x-jet-input>
        </div>
        <div class="flex items-center flex-1">
            <x-jet-input class="flex-1" wire:model="search" type="text" placeholder="Buscar producto" required
                autofocus />
        </div>
    </div>
    <section x-data="{ type_search: @entangle('type_search') }">
        <div class="flex items-center p-3 mb-3 bg-white rounded-lg shadow-lg">
            <div>
                <label class="mr-2">
                    <input value="1" type="radio" x-model="type_search" name="type_search">
                    <span class="ml-2">
                        {{ __('Código de barras') }}
                    </span>
                </label>
                <label class="ml-2">
                    <input value="2" type="radio" x-model="type_search" name="type_search">
                    <span class="ml-2">
                        {{ __('Descripción') }}
                    </span>
                </label>
            </div>
        </div>
    </section>

    @if ($alert == true)
        <div class="flex items-center justify-between p-3 mt-3 bg-gray-500 rounded-lg shadow-lg">

            <span class="ml-2 text-lg font-bold text-center text-white">
                {{ __('No hay producto en existencia') }}
            </span>

            <x-jet-danger-button wire:click='alert'>
                X
            </x-jet-danger-button>
        </div>
    @endif


    <div class="mt-3">
        <table class="w-full tables">
            <thead>
                <th>CÓDIGO</th>
                <th>DESCRIPCIÓN</th>
                <th>EXISTENCIA</th>
                <th>PRECIO</th>
                <th></th>
            </thead>

            @if ($search != null)
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td class="text-center">
                                {{ $producto->barcode }}
                            </td>
                            <td>
                                {{ $producto->description }}
                            </td>
                            <td class="text-center">
                                {{ $producto->stock }}
                            </td>
                            <td class="font-bold text-center">
                                <b>$</b>{{ number_format($producto->price, 2, '.', ',') }}
                            </td>
                            <td>
                                @if ($producto->stock > 0)
                                    <x-jet-button wire:click='addItem({{ $producto }})'>
                                        VENDER
                                    </x-jet-button>
                                @else
                                    <x-jet-button disabled>
                                        VENDER
                                    </x-jet-button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="py-3 text-center">
                                <span class="text-lg font-bold text-gray-700 text">
                                    Aun no ha realizado ninguna busqueda.
                                </span>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>
