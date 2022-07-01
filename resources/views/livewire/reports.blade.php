<div class="p-3">
    <section x-data="{ type_search: @entangle('type_search') }">

        <div class="flex items-center hidden p-3" :class="{ 'hidden': type_search == 2 }">
            <x-jet-input class="flex-1" wire:model="search" type="text" placeholder="Buscar venta" required autofocus />
        </div>
        <div class="flex items-center hidden p-3" :class="{ 'hidden': type_search == 1 }">
            <x-jet-input class="flex-1" wire:model="search" type="date" placeholder="Buscar venta" required
                autofocus />
        </div>
        <div class="flex items-center p-3 mb-3 bg-white rounded-lg shadow-lg">
            <div>
                <label class="mr-2">
                    <input value="1" type="radio" x-model="type_search" name="type_search">
                    <span class="ml-2">
                        {{ __('ID de venta') }}
                    </span>
                </label>
                <label class="ml-2">
                    <input value="2" type="radio" x-model="type_search" name="type_search">
                    <span class="ml-2">
                        {{ __('Fecha de venta') }}
                    </span>
                </label>
            </div>
        </div>
    </section>

    <table class="tables">
        <thead>
            <th>
                Ticket
            </th>
            <th>
                Fecha
            </th>
            <th>
                Costo
            </th>
            <th>
                Total
            </th>
            <th>
                Ganancia
            </th>
            @can('reports.print')
                <th>
                    Ticket
                </th>
            @endcan
            @can('reports.show')
                <th>
                    Detalles
                </th>
            @endcan
            @can('reports.delete')
                <th>
                    Eliminar
                </th>
            @endcan
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td>
                        {{ $venta->id }}
                    </td>
                    <td>
                        {{ Date::parse($venta->created_at)->locale('es')->format('l j F Y H:i:s') }}
                    </td>
                    <td class="font-bold text-center">
                        <b>$</b>{{ number_format($venta->costo, 2, '.', ',') }}
                    </td>
                    <td class="font-bold text-center">
                        <b>$</b>{{ number_format($venta->total, 2, '.', ',') }}
                    </td>
                    <td class="font-bold text-center">
                        <b>$</b>{{ number_format($venta->ganancia, 2, '.', ',') }}
                    </td>
                    @can('reports.print')
                        <td>
                            <div class="flex justify-center">
                                <x-jet-button wire:click='printTicket({{ $venta }})'>
                                    <i class="text-xl fas fa-print"></i>
                                </x-jet-button>
                            </div>
                        </td>
                    @endcan
                    @can('reports.show')
                        <td>
                            <div class="flex justify-center">
                                <x-jet-secondary-button wire:click='SelectCliente({{$venta}})'>
                                    <i class="text-xl fas fa-info"></i>
                                </x-jet-secondary-button>
                                <x-jet-secondary-button wire:click='show({{ $venta }})'>
                                    <i class="text-xl fas fa-info"></i>
                                </x-jet-secondary-button>
                            </div>
                        </td>
                    @endcan
                    @can('reports.delete')
                        <td>
                            <div class="flex justify-center">
                                <x-jet-danger-button wire:click='delete({{ $venta }})'>
                                    <i class="text-xl fas fa-trash"></i>
                                </x-jet-danger-button>
                            </div>
                        </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>

    <x-jet-dialog-modal wire:model='selectCliente'>

        <x-slot name="title">
            Editar Cliente
        </x-slot>
        <x-slot name="content">
            {!! Form::open() !!}
            <div>
                <x-jet-label>Categoria:</x-jet-label>
                {!! Form::select('idClient', $clientes, null, ['wire:model' => 'idClient', 'placeholder' => 'Elija una opción', 'class' => 'form-input']) !!}
                <x-jet-input-error for="idClient"></x-jet-input-error>
            </div>
            {!! Form::close() !!}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="mr-3" wire:click='selectCliente({{ $venta }})'>
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click='createFactura'>
                Facturar
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
