<div class="container p-3 mx-auto">

    <div class="flex items-center p-3 mb-3 bg-white rounded-lg shadow-lg">

        <div class="mr-2">
            <strong class="mr-2">Cantidad:</strong>
            <x-jet-input class="w-20" type="number" wire:model='qty'></x-jet-input>
        </div>
        <div class="mr-2">
            <strong class="mr-2">Clave:</strong>
            <x-jet-input class="flex-1" wire:model="search" type="text" placeholder="Buscar producto" required
                autofocus />
        </div>
        <div class="flex items-center justify-end flex-1">
            <strong class="mr-2">Tipo de venta:</strong>
            <section x-data="{ type_sale: @entangle('type_sale') }">
                <div>
                    <label class="mr-2">
                        <input value="1" type="radio" x-model="type_sale" name="type_sale">
                        <span class="ml-2">
                            {{ __('Venta normal') }}
                        </span>
                    </label>
                    <label class="ml-2">
                        <input value="2" type="radio" x-model="type_sale" name="type_sale">
                        <span class="ml-2">
                            {{ __('Caja chica') }}
                        </span>
                    </label>
                </div>
            </section>
        </div>
    </div>

    <table class="w-full tables">
        <thead>
            <th>CANTIDAD</th>
            <th>NOMBRE</th>
            <th>P/UNITARIO</th>
            <th>IMPORTE</th>
            <th></th>
        </thead>
        <tbody>
            @foreach (Cart::content() as $item)
                <tr>

                    <td class="text-center">
                        <span class="font-bold">
                            {{ $item->qty }}
                        </span>
                    </td>
                    <td>
                        <span>
                            {{ $item->name }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span>
                            <b>$</b>{{ number_format($item->price, 2, '.', ',') }}
                        </span>
                    </td>
                    <td class="font-bold text-center">
                        <span>
                            <b>$</b>{{ number_format($item->price * $item->qty, 2, '.', ',') }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center">
                            <span class="text-red-600 cursor-pointer" wire:click="removeItem('{{ $item->rowId }}')">
                                <i class="fas fa-trash"></i>
                            </span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <div class="flex justify-end text-lg font-bold ">
                        <span>
                            Total: $ {{ Cart::subtotal() }} MXN
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="font-bold text-center ">
                    @livewire('components.payment-sale')
                </td>
            </tr>
        </tfoot>
    </table>

</div>
