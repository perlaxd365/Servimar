<h3>
    Editar Usuario
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
        <label for="">Nombre</label>
        <input wire:model='name' type="text" class="form-control" placeholder="Ingresar Nombre">
    </div>
    <div class="form-group col-md-6">
        <label for="">DNI</label>
        <input wire:model='dni' maxlength="8" type="text" class="form-control" placeholder="Ingresar DNI">
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Sede</label>
        <select wire:model="id_sede" class="form-control" name="" id="">
            <option value="">Seleccionar Sede</option>
            @foreach ($sedes as $sede)
                <option value="{{ $sede->id_sede }}">{{ $sede->descripcion }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="">Email</label>
        <input wire:model='email' type="email" class="form-control" placeholder="Ingresar Correo">
    </div>
</div>

  <br>
  
  <button wire:click="update" wire:loading.attr="disabled" class="btn btn-primary" type="button"> <i
    class="fas fa-pencil-alt"></i> <i wire:target="update" wire:loading.class="fa fa-spinner fa-spin"
    aria-hidden="true"></i> Actualizar</button>

<button wire:click="default" wire:loading.attr="disabled" class="btn btn-secondary" type="button"> <i
    class="fa fa-window-close"></i> <i wire:target="default" wire:loading.class="fa fa-spinner fa-spin"
    aria-hidden="true"></i> Cancelar</button>
  <br>
  