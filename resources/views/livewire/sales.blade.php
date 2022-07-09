<div class="p-3">
    <div class="p-3 mb-3 bg-white rounded-lg shadow-lg">
        <div class="items-center justify-between block md:flex">
            <div class="items-center block p-3 md:flex">
                <strong> Número de Ticket:</strong>
                <x-jet-input class="w-full ml-1 md:flex-1" wire:model="search" type="text" placeholder="Buscar venta" required
                    autofocus />
            </div>
            <div class="items-center block p-3 md:flex">
                <strong>Fecha de venta:</strong>
                <x-jet-input class="w-full ml-1 md:flex-1" wire:model="day" type="date" placeholder="Buscar venta" required
                    autofocus />
            </div>

            <section x-data="{ facturable: @entangle('facturable') }">
                <div class="items-center block p-3 md:flex">
                    <div class="mr-1">
                        <strong>Tipo de venta:</strong>
                    </div>
                    <label class="mr-1">
                        <input value="1" type="radio" x-model="facturable" name="facturable">
                        <span>
                            {{ __('Venta normal') }}
                        </span>
                    </label>
                    <label class="mr-1">
                        <input value="2" type="radio" x-model="facturable" name="facturable">
                        <span>
                            {{ __('Caja chica') }}
                        </span>
                    </label>
                </div>
            </section>
        </div>
        <div class="items-center justify-between block md:flex">
            <section x-data="{ type_payment: @entangle('type_payment') }">
                <div class="items-center block p-3 md:flex">
                    <div class="mr-1">
                        <strong>Tipo de pago:</strong>
                    </div>
                    <label class="mr-1">
                        <input value="1" type="radio" x-model="type_payment" name="type_payment">
                        <span>
                            {{ __('Efectivo') }}
                        </span>
                    </label>
                    <label class="mr-1">
                        <input value="2" type="radio" x-model="type_payment" name="type_payment">
                        <span>
                            {{ __('Debito') }}
                        </span>
                    </label>
                    <label class="mr-1">
                        <input value="3" type="radio" x-model="type_payment" name="type_payment">
                        <span>
                            {{ __('Credito') }}
                        </span>
                    </label>
                </div>
            </section>
            <x-jet-secondary-button wire:click='facturaDay'>
                Facturar ventas
            </x-jet-secondary-button>
        </div>
    </div>

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
                                <x-jet-secondary-button wire:click='SelectCliente({{ $venta }})'>
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
    @endpush
</div>
