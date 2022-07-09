<div>
    <div class="p-3 mb-3 bg-white rounded-lg shadow-lg">
        <div class="items-center justify-between block md:flex">
            <section x-data="{ caja: @entangle('caja') }">
                <div class="items-center block p-3 md:flex">
                    <div class="mr-1">
                        <strong>Número de caja:</strong>
                    </div>
                    <label class="mr-1">
                        <input value="1" type="radio" x-model="caja" name="caja">
                        <span>
                            {{ __('Caja 1') }}
                        </span>
                    </label>
                    <label class="mr-1">
                        <input value="2" type="radio" x-model="caja" name="caja">
                        <span>
                            {{ __('Caja 2') }}
                        </span>
                    </label>
                </div>
            </section>
            <x-jet-button wire:click='create'>
                Corte de caja
            </x-jet-button>

        </div>
    </div>


    <x-jet-dialog-modal wire:model='create'>

        <x-slot name="title">
            Corte de caja
        </x-slot>

        <x-slot name="content">

            <div class="grid grid-cols-4 gap-3">

                {!! Form::label('total', ' ', ['class' => 'font-bold text-sm text-center']) !!}
                {!! Form::label('total', 'Contado', ['class' => 'font-bold text-sm text-center']) !!}
                {!! Form::label('total', 'Calculado', ['class' => 'font-bold text-sm text-center']) !!}
                {!! Form::label('total', 'Diferencia', ['class' => 'font-bold text-sm text-center']) !!}

                {!! Form::label('total', 'Efectivo', ['class' => 'font-bold text-sm text-center']) !!}
                <x-jet-input class="flex-1" type="number" wire:model='c_Efectivo' required autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='tEfectivo' required disabled autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='dEfectivo' required disabled autofocus />

                {!! Form::label('total', 'T/Debito', ['class' => 'font-bold text-sm text-center']) !!}
                <x-jet-input class="flex-1" type="number" wire:model='c_Debito' required autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='tDebito' required disabled autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='dDebito' required disabled autofocus />

                {!! Form::label('total', 'T/Credito', ['class' => 'font-bold text-sm text-center']) !!}
                <x-jet-input class="flex-1" type="number" wire:model='c_Credito' required autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='tCredito' required disabled autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='dCredito' required disabled autofocus />

                {!! Form::label('total', 'Total', ['class' => 'font-bold text-sm text-center']) !!}
                <x-jet-input class="flex-1" type="number" wire:model='c_Total' required disabled autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='tTotal' required disabled autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='dTotal' required disabled autofocus />

            </div>

            <h1 class="font-bold text-center">
                Retiro por corte
            </h1>

            <div class="grid grid-cols-4 gap-3">

                {!! Form::label('total', 'Efectivo', ['class' => 'font-bold text-sm text-center']) !!}
                {!! Form::label('total', 'Tarjeta', ['class' => 'font-bold text-sm text-center']) !!}
                {!! Form::label('total', 'Total', ['class' => 'font-bold text-sm text-center']) !!}
                {!! Form::label('total', 'Fondo', ['class' => 'font-bold text-sm text-center']) !!}

                <x-jet-input class="flex-1" type="number" wire:model='r_Efectivo' required autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='r_Tarjeta' required autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='rTotal' required disabled autofocus />
                <x-jet-input class="flex-1" type="number" wire:model='fondo' required disabled autofocus />


            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-button wire:click='store'>
                Hacer corte
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
