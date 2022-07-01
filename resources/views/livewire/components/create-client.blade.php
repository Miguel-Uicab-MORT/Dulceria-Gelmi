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
                    <x-jet-label>Nombre del cliente:</x-jet-label>
                    {!! Form::text('name', null, ['wire:model' => 'name', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="name"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Apellidos:</x-jet-label>
                    {!! Form::text('lastname', null, ['wire:model' => 'lastname', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="lastname"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Razón Social:</x-jet-label>
                    {!! Form::text('bussinessname', null, ['wire:model' => 'businessname', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="bussinessname"></x-jet-input-error>
                </div>
                <div>
                    <x-jet-label>Número:</x-jet-label>
                    {!! Form::number('number', null, ['wire:model' => 'number', 'class' => 'form-input']) !!}
                    <x-jet-input-error for="number"></x-jet-input-error>
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
                <div>
                    <div wire:ignore>
                        <x-jet-label value="Estado/Provincia/Región"></x-jet-label>
                        <select class="form-input" id="selected-estado" wire:model="state">
                            <option disabled selected>Elige un estado</option>
                        </select>
                    </div>
                    <x-jet-input-error for="state"></x-jet-input-error>
                </div>
                <div>
                    <div wire:ignore>
                        <x-jet-label value="Ciudad/Municipio"></x-jet-label>
                        <select class="form-input" id="selected-municipio" wire:model="city">
                            <option disabled selected>Elige un municipio</option>
                        </select>
                    </div>
                    <x-jet-input-error for="city"></x-jet-input-error>
                </div>
                <div>
                    <div wire:ignore>
                        <x-jet-label value="Colonia"></x-jet-label>
                        <select class="form-input" name="" id="selected-colonia" wire:model="colony">
                            <option disabled selected>Elige una colonia</option>
                        </select>
                    </div>
                    <x-jet-input-error for="colony"></x-jet-input-error>
                </div>
            </div>

            <div class="w-full mt-5">
                <x-jet-label>Direccion:</x-jet-label>
                {!! Form::text('address', null, ['wire:model' => 'address', 'class' => 'form-input']) !!}
                <x-jet-input-error for="address"></x-jet-input-error>
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

    @push('js')
        <script>
            const d = document,
                $inpupCp = d.getElementById("cp"),
                $selectEstado = d.getElementById("selected-estado"),
                $selectMunicipio = d.getElementById("selected-municipio"),
                $selectColonia = d.getElementById("selected-colonia");

            function loadStates() {
                fetch("https://api.copomex.com/query/get_estados?token=pruebas")
                    .then(res => res.ok ? res.json() : Promise.reject(res))
                    .then(json => {
                        console.log(json);
                        let $options = `<option disabled selected value="">Elige un estado</option>`;
                        json.response.estado.forEach(el => $options += `<option value="${el}">${el}</option>`);
                        $selectEstado.innerHTML = $options;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            function loadMunicipios(state) {
                fetch(
                        `https://api.copomex.com/query/get_municipio_por_estado/${state}?token=pruebas`)
                    .then(res => res.ok ? res.json() : Promise.reject(res))
                    .then(json => {
                        console.log(json);
                        let $options = `<option disabled selected value="">Elige un municipio</option>`;
                        json.response.municipios.forEach(el => $options += `<option value="${el}">${el}</option>`);
                        $selectMunicipio.innerHTML = $options;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            function loadColonias(cp) {
                fetch(`https://api.copomex.com/query/get_colonia_por_cp/${cp}?token=pruebas`)
                    .then(res => res.ok ? res.json() : Promise.reject(res))
                    .then(json => {
                        console.log(json);
                        let $options = `<option value="">Elige una colonia</option>`;
                        json.response.colonia.forEach(el => $options += `<option value="${el}">${el}</option>`);
                        $selectColonia.innerHTML = $options;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            d.addEventListener("DOMContentLoaded", loadStates());
            $selectEstado.addEventListener("change", e => loadMunicipios(e.target.value));
            $inpupCp.addEventListener("change", e => loadColonias(e.target.value));
        </script>
    @endpush
</div>
