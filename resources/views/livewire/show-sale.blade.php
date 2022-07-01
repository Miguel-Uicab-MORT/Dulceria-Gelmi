<div class="p-3">
    <div class="flex items-center justify-between p-3 mb-3 bg-white rounded-lg shadow-lg">
        <x-jet-secondary-button wire:click='index'>
            Regresar
        </x-jet-secondary-button>

        <h1>
            <b>Detalle de la venta: </b> {{$venta->id}}
        </h1>

        <x-jet-button wire:click='printTicket({{$venta}})'>
            <i class="text-2xl fas fa-print"></i>
        </x-jet-button>
    </div>
    <table class="tables">
        <thead>
            <th>Descripción</th>
            <th>Costo</th>
            <th>Precio</th>
            <th>Ganancia</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td class="text-justify ">
                        {{$item->name}}
                    </td>
                    <td class="text-center ">
                        <b>$</b>{{ number_format($item->options->cost, 2, '.', ',')}}
                    </td>
                    <td class="text-center ">
                        <b>$</b>{{ number_format($item->price, 2, '.', ',')}}
                    </td>
                    <td class="text-center ">
                        <b>$</b>{{ number_format($item->options->gain, 2, '.', ',')}}
                    </td>
                    <td class="text-center ">
                        {{$item->qty}}
                    </td>
                    <td class="text-center ">
                        <b>$</b>{{ number_format($item->qty * $item->price, 2, '.', ',')}}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="font-bold text-center ">
                    Costo Total
                </td>
                <td class="font-bold text-center ">
                    ${{number_format($venta->costo, 2, '.', ',')}}
                </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="font-bold text-center ">
                    Total
                </td>
                <td class="font-bold text-center ">
                    ${{number_format($venta->total, 2, '.', ',')}}
                </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="font-bold text-center ">
                    Ganancia Total
                </td>
                <td class="font-bold text-center ">
                    ${{number_format($venta->ganancia, 2, '.', ',')}}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
