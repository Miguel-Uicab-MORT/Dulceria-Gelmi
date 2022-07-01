<div class="px-3 py-6">
    @if (Cart::count())
        <table class="w-full tables">
            <thead>
                <th>Cantidad</th>
                <th>Nombre</th>
                <th>P/UNITARIO</th>
                <th>Total</th>
                <th></th>
            </thead>
            <tbody>
                @foreach (Cart::content() as $item)
                    <tr>

                        <td class="text-center">
                            <span class="font-bold">
                                {{$item->qty}}
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
                                <span class="text-red-600 cursor-pointer"
                                    wire:click="removeItem('{{ $item->rowId }}')">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="font-bold text-center">
                        <div class="text-lg ">
                            <span>
                                Total
                            </span>
                        </div>
                    </td>
                    <td colspan="2" class="font-bold text-center">
                        <div class="text-lg ">
                            <span>
                                ${{Cart::subtotal()}}
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="font-bold text-center">
                        @livewire('components.payment-sale')
                    </td>
                </tr>
            </tfoot>
        </table>
    @else
        <table class="w-full tables">
            <thead>
                <th>Cantidad</th>
                <th>Nombre</th>
                <th>P/UNITARIO</th>
                <th>Total</th>
                <th></th>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <div class="py-3 text-center">
                            <span class="text-lg font-bold text-gray-700 text">TU CARRITO ESTÁ VACÍO</span>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif
</div>
