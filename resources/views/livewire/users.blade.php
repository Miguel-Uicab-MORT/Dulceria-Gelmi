<div class="max-w-6xl mx-auto p-3">
    <div class="flex items-center p-3 mb-3 shadow-xl rounded-md">
        <div class="flex items-center flex-1">
            <x-jet-input class="flex-1" wire:model="search" type="text" placeholder="Buscar producto" required
                autofocus />
        </div>
        @can('users.create')
        <div class="ml-2">
            @livewire('components.create-user')
        </div>
        @endcan
    </div>

    <div class="mt-3">
        <table class="w-full tables">
            <thead>
                <th>NOMBRE</th>
                <th>EMAIL</th>
                <th></th>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td class="flex justify-end">
                            @can('users.edit')
                            <x-jet-secondary-button wire:click='edit({{ $user }})'>
                                Editar Roles
                            </x-jet-secondary-button>
                            @endcan
                            @can('users.delete')
                                <x-jet-danger-button class="ml-1" wire:click='delete({{ $user }})'>
                                    Borrar
                                </x-jet-danger-button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <div class="py-1 text-center">
                            {{ $users->links() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
