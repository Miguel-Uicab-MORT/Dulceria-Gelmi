<div>
    <x-jet-button wire:click='paymentModal'>
        Pagar
    </x-jet-button>

    <x-jet-dialog-modal wire:model='paymentModal'>
        <x-slot name="title">
            Pago
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2">
                {!! Form::label('total', 'Total a pagar $:', ['class' => 'strong flex items-center justify-end mr-3 text-right']) !!}
                <x-jet-input class="flex-1" type="text" wire:model='total' required disabled autofocus />
            </div>
            <div class="grid grid-cols-2 mt-3">
                {!! Form::label('efectivo', 'Efectivo $:', ['class' => 'strong flex items-center justify-end mr-3 text-right']) !!}
                <div>
                    <x-jet-input class="w-full" wire:model="efectivo" type="number" placeholder="Recibi" required
                        autofocus />
                    <x-jet-input-error for="efectivo"></x-jet-input-error>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-3">
                {!! Form::label('efectivo', 'Tarjeta/Debito $:', ['class' => 'strong flex items-center justify-end mr-3 text-right']) !!}
                <div>
                    <x-jet-input class="w-full" wire:model="debito" type="number" placeholder="Recibi" required
                        autofocus />
                    <x-jet-input-error for="debito"></x-jet-input-error>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-3">
                {!! Form::label('efectivo', 'Tarjeta/Credito $:', ['class' => 'strong flex items-center justify-end mr-3 text-right']) !!}
                <div>
                    <x-jet-input class="w-full" wire:model="credito" type="number" placeholder="Recibi" required
                        autofocus />
                    <x-jet-input-error for="credito"></x-jet-input-error>
                </div>
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click='paymentModal'>
                Cancelar
            </x-jet-secondary-button>
            @if ($recibido < $total)
                <x-jet-button class="ml-1" wire:click='paymentSale' disabled>
                    Cobrar
                </x-jet-button>
            @else
                <x-jet-button class="ml-1" wire:click='paymentSale'>
                    Cobrar
                </x-jet-button>
            @endif

        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model='cambioModal'>
        <x-slot name="title">
            Detalles
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2">
                {!! Form::label('total', 'Total a pagar $:', ['class' => 'strong flex items-center justify-end mr-3 text-right']) !!}
                <x-jet-input class="flex-1" type="text" wire:model='total' required disabled autofocus />
            </div>
            <div class="grid grid-cols-2 mt-3">
                {!! Form::label('efectivo', 'Efectivo $:', ['class' => 'strong flex items-center justify-end mr-3 text-right']) !!}
                <div>
                    <x-jet-input class="w-full" wire:model="efectivo" type="number" placeholder="Recibi" required
                        autofocus />
                    <x-jet-input-error for="efectivo"></x-jet-input-error>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-3">
                {!! Form::label('efectivo', 'Tarjeta/Debito $:', ['class' => 'strong flex items-center justify-end mr-3 text-right']) !!}
                <div>
                    <x-jet-input class="w-full" wire:model="debito" type="number" placeholder="Recibi" required
                        autofocus />
                    <x-jet-input-error for="debito"></x-jet-input-error>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-3">
                {!! Form::label('efectivo', 'Tarjeta/Credito $:', ['class' => 'strong flex items-center justify-end mr-3 text-right']) !!}
                <div>
                    <x-jet-input class="w-full" wire:model="credito" type="number" placeholder="Recibi" required
                        autofocus />
                    <x-jet-input-error for="credito"></x-jet-input-error>
                </div>
            </div>

            <div class="grid grid-cols-2 mt-3">
                {!! Form::label('total', 'Cambio', ['class' => 'strong flex items-center justify-end mr-3 text-right']) !!}
                <x-jet-input type="number" value="{{ $cambio }}" disabled autofocus></x-jet-input>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='cambioModal'>
                Finalizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
