<div class="card-header">
    <h5>
        <strong>
            <div class="form-group col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary">
                        Punto de abastecimiento
                    </div>
                    <div class="card-body">
                        @foreach ($productos as $producto)
                            <textarea class="form-control" id="exampleFormControlTextarea1" readonly rows="3">
                                Nombre : {{ $producto->nombre_pro }}
                                Stock : {{ $producto->stock_pro }}
                                Precio : {{ $producto->precio_pro }}
                            </textarea>
                            <input wire:model='id_producto' class="form-control" value="{{ $producto->id_producto }}"
                                type="hidden" placeholder="Readonly input here…" readonly>
                        @endforeach
                    </div>
                </div>
            </div>
        </strong>
    </h5>
</div>

<div class="card-body form-row">

    <div class="form-group col-md-12">
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
        <h4>Datos de Embarcación</h4>
    </div>
    <div class="form-group col-md-12">
        <label for="">Embarcacion</label>
        <div class="row">
            <div class="col-8">
                <input wire:model='nombre_emb' readonly type="text" class="form-control"
                    placeholder="Seleccionar Embarcación">
                <input wire:model='id_emb' type="hidden" class="form-control">
            </div>
            <div class="col-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#buscarEmbarcacion">Buscar
                    Embarcación</button>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="divider py-1 bg-dark"></div>
    <hr class="mt-5 mb-5">
    <div class="form-group col-md-12">
        <h4>Datos de Venta</h4>
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Galones</label>
        <input wire:model='galonaje_venta' wire:keyup='calcularTotal' wire:keypress='calcularTotal' wire:keydown='calcularTotal' autocomplete="off" type="number" Step="0"
            class="form-control solo-numero" id="exampleInputEmail1" placeholder="Ingresar Cantidad de Galones">
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Tipo de Pago</label>
        <select wire:model="id_tipo_pago" class="form-control" name="" id="">
            <option value="">Seleccionar Tipo de Pago</option>
            @foreach ($tipoPagos as $tipo)
                <option value="{{ $tipo->id_tipo_pago }}">{{ $tipo->nombre_tipo_pago }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Precio</label>
        <input wire:model='precio_venta' type="number" autocomplete="off" Step="0"
            class="form-control solo-numero" id="exampleInputEmail1" placeholder="Ingresar Precio">
    </div>
    <br>
    <div class="divider py-1 bg-dark"></div>
    <hr class="mt-5 mb-5">
    <div class="form-group col-md-12">
        <h4>Datos de Referencia</h4>
    </div>

    <div class="form-group col-md-6">
        <label for="">Nombres y Apellidos</label>
        <input wire:model='nombre_ref_venta' type="text" class="form-control"
            placeholder="Ingresar Nombres de Referencia">
    </div>
    <div class="form-group col-md-6">
        <label for="">DNI</label>
        <input wire:model='dni_ref_venta' type="text" class="form-control" placeholder="Ingresar DNI de Referencia">
    </div>
    <div class="form-group col-md-6">
        <label for="">Teléfono</label>
        <input wire:model='telefono_ref_venta' type="text" class="form-control"
            placeholder="Ingresar teléfono de Referencia">
    </div>
    <div class="container">
        <div class="card-body form-row">
            <button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary" type="button"> <i
                    class="fa fa-plus-circle"></i> <i wire:target="store" wire:loading.class="fa fa-spinner fa-spin"
                    aria-hidden="true"></i> Agregar</button>
            <br>
        </div>
    </div>
</div>


<br>



<!-- Modal -->
<div wire:ignore.self class="modal fade" id="buscarEmbarcacion" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Buscar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group col-md-12">
                    <input wire:model='searchEmbarcacion' type="text" class="form-control"
                        placeholder="Buscar Cliente">
                </div>
                <div class="table-responsive">
                    @if ($embarcaciones->count())
                        <table class="table">
                            <thead class="">
                                <tr>
                                    <th>
                                        Embarcaciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                    td:hover {
                                        background-color: beige;
                                    }
                                </style>
                                @foreach ($embarcaciones as $embarcacion)
                                    <tr wire:click="seleccionEmbarcacion('{{ $embarcacion->id }}','{{ $embarcacion->nombre_emb }}')"
                                        style="cursor: pointer; tr:hover{ background-color: yellow}">
                                        <td>
                                            {{ $embarcacion->nombre_emb }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="card-footer container justify-content-center d-inline-flex ">
                            {{ $embarcaciones->links() }}
                        </div>
                    @else
                        <div class="card-body">
                            <strong>No se encontraron resultados</strong>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('close-modal', event => {
        var producto = event.detail.producto;
        $('#buscarEmbarcacion').modal('hide');

    });
</script>
