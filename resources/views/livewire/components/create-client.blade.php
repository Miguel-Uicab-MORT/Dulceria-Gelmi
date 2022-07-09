<div>
    <x-jet-button wire:click='create'>
        Nuevo Cliente
    </x-jet-button>

    <x-jet-dialog-modal wire:model='create'>

        <x-slot name="title">
            Nuevo Cliente
        </x-slot>
        <x-slot name="content">
            {!! Form::open() !!}
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <x-jet-label>Razón Social:</x-jet-label>
                    {!! Form::text('bussinessname', null, ['wire:model' => 'businessname', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="bussinessname"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Email:</x-jet-label>
                    {!! Form::email('email', null, ['wire:model' => 'email', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="email"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Tipo de persona:</x-jet-label>
                    {!! Form::select('personType', $typePerson, null, ['placeholder' => 'Selecciona una opción', 'wire:model' => 'personType', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="personType"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>RFC:</x-jet-label>
                    {!! Form::text('rfc', null, ['wire:model' => 'rfc', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="rfc"></x-jet-input-error>
                </div>
                <div>
                    <div wire:ignore>
                        <x-jet-label value="Codigo Postal"></x-jet-label>
                        <x-jet-input type="number" id="cp" placeholder="Ingrese su codigo postal" class="w-full"
                            wire:model="cp"></x-jet-input>
                    </div>
                    <x-jet-input-error for="cp"></x-jet-input-error>
                </div>
            </div>

            {!! Form::close() !!}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="mr-3" wire:click='create'>
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click='store'>
                Guardar
            </x-jet-button>

        </x-slot>

    </x-jet-dialog-modal>

</div>
