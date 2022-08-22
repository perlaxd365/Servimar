<h3>
    Nuevo Cliente (Empresa)
</h3>
<br>
@if (count($errors) > 0)
    <div class="alert border-danger">
        <p>Se encontraron los siguientes errores:</p>
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="">Dueño de la empresa</label>
        <input wire:model='duenio_cli' type="text" class="form-control" placeholder="Ingresar al dueño">
    </div>
    <div class="form-group col-md-6">
        <label for="">Razón Social</label>
        <input wire:model='razon_cli' type="text" class="form-control" placeholder="Ingresar Razón Social">
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Tipo de Persona</label>
        <select wire:model="id_persona" class="form-control" name="" id="">
            <option value="">Seleccionar Tipo de Persona</option>
            @foreach ($tipoPersona as $persona)
                <option value="{{ $persona->id_persona }}">{{ $persona->nombre_per }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="">RUC</label>
        <input wire:model='ruc_cli' maxlength="11" type="text" class="form-control" placeholder="Ingresar RUC">
    </div>
    <div class="form-group col-md-6">
        <label for="">DNI</label>
        <input wire:model='dni_cli' maxlength="8" type="text" class="form-control" placeholder="Ingresar DNI">
    </div>
    <div class="form-group col-md-6">
        <label for="">Nombres y Apellidos</label>
        <input wire:model='nombre_cli' type="text" class="form-control" placeholder="Ingresar Nombres y Apellidos">
    </div>
    <div class="form-group col-md-6">
        <label for="">Teléfono</label>
        <input wire:model='telefono_cli' maxlength="12" type="text" class="form-control" placeholder="Ingresar Teléfono">
    </div>
    <div class="form-group col-md-6">
        <label for="">Correo</label>
        <input wire:model='email_cli' type="text" class="form-control" placeholder="Ingresar correo">
    </div>
</div>

<br>

<button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary" type="button"> <i
        class="fa fa-plus-circle"></i> <i wire:target="store" wire:loading.class="fa fa-spinner fa-spin"
        aria-hidden="true"></i> Agregar</button>
<br>
