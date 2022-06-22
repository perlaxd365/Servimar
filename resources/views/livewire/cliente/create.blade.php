<h3>
    Nuevo Cliente
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
        <label for="">Razón Social</label>
        <input wire:model='razon_cli' type="text" class="form-control" placeholder="Ingresar Razón Social">
    </div>
    <div class="form-group col-md-6">
        <label for="">RUC</label>
        <input wire:model='ruc_cli' type="text" class="form-control" placeholder="Ingresar RUC">
    </div>
    <div class="form-group col-md-6">
        <label for="">Nombres y Apellidos</label>
        <input wire:model='nombre_cli' type="text" class="form-control" placeholder="Ingresar Nombres y Apellidos">
    </div>
    <div class="form-group col-md-6">
        <label for="">Teléfono</label>
        <input wire:model='telefono_cli' type="text" class="form-control" placeholder="Ingresar Teléfono">
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
