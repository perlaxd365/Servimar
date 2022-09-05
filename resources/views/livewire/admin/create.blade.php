<h3>
  Nuevo Usuario
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
        <label for="">Nombres y Apellidos</label>
        <input wire:model='name' type="text" class="form-control" placeholder="Ingresar Nombre">
    </div>
    <div class="form-group col-md-6">
        <label for="">DNI</label>
        <input wire:model='dni' maxlength="8" type="text" class="form-control" placeholder="Ingresar DNI">
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Punto</label>
        <select wire:model="id_sede" class="form-control" name="" id="">
            <option value="">Seleccionar Punto</option>
            @foreach ($sedes as $sede)
                <option value="{{ $sede->id_sede }}">{{ $sede->descripcion }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="">Email</label>
        <input wire:model='email' type="email" class="form-control" placeholder="Ingresar Correo">
    </div>
    <div class="form-group col-md-6">
        <label for="">Ingresar Contraseña</label>
        <input wire:model='pass1' type="password" class="form-control" placeholder="Ingresar Contraseña">
    </div>
    <div class="form-group col-md-6">
        <label for="">Vuelve a ingresar Contraseña</label>
        <input wire:model='pass2' type="password" class="form-control" placeholder="Vuelve a ingresar Contraseña">
    </div>
</div>

<br>

<button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary"
type="button"> <i class="fa fa-plus-circle"></i> <i wire:target="store"
    wire:loading.class="fa fa-spinner fa-spin" aria-hidden="true"></i> Agregar</button>
<br>
