<div>
    <x-jet-button wire:click='create'>
        Añadir Categoria
    </x-jet-button>

    <x-jet-dialog-modal wire:model='create'>

        <x-slot name="title">
            Editar Categoria
        </x-slot>
        <x-slot name="content">
            {!! Form::open() !!}
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <x-jet-label>Nombre del producto:</x-jet-label>
                    {!! Form::text('name', null, ['wire:model' => 'name', 'placeholder' => 'Nombre del producto', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="name"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Estatus:</x-jet-label>
                    {!! Form::select('status', $statusList, null, ['wire:model' => 'status', 'placeholder' => 'Elija una opción', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="status"></x-jet-input-error>
                </div>
            </div>
            {!! Form::close() !!}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button class="mr-3" wire:click='create'>
                Cancelar
            </x-jet-secondary-button>
            @can('category.store')
                <x-jet-button wire:click='store'>
                    Guardar
                </x-jet-button>
            @endcan
        </x-slot>

    </x-jet-dialog-modal>
</div>
