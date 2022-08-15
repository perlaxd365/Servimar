<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

<div class="card-header">
    <div class="form-group col-md-12">
        <div class="card-body">
            <div class="card" style="width: 100%">

                @foreach ($productos as $producto)
                    <div class="card-header bg-dark">
                        <strong>{{ $producto->nombre_pro }}</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Stock</strong> : {{ $producto->stock_pro }}</li>
                        <li class="list-group-item"><strong>Precio por Galón</strong> : {{ $producto->precio_pro }}</li>
                    </ul>

                    <input wire:model='id_producto' wire:ignore.self class="form-control" type="hidden"
                        placeholder="Readonly input here…">
                @endforeach
            </div>
        </div>
    </div>
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
        <input wire:model='galonaje_venta' wire:keyup='calcularTotal' wire:keypress='calcularTotal'
            wire:keydown='calcularTotal' autocomplete="off" type="number" Step="0"
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
    <div class="form-group col-md-6">
        <label for="inputEmail4">Moneda</label>
        <select wire:model="moneda_venta" class="form-control" name="" id="">
            <option value="">Seleccionar Moneda</option>
            <option value="Soles">Soles</option>
            <option value="Dolares">Dolares ({{ $dolares }})</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail4">Mostrar Precio</label>

        <label class="switch" style="size: 4cm">
            <input wire:model="mostrarPrecio" type="checkbox" checked>
            <span class="slider round"></span>
        </label>
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
                    aria-hidden="true"></i> Registrar Venta</button>
            <br>
        </div>
    </div>
</div>


<br>



<!-- Modal -->
<div wire:ignore.self class="modal fade" id="buscarEmbarcacion" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
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
                        placeholder="Buscar por cliente o embarcacion">
                </div>
                <div class="table-responsive">
                    @if ($embarcaciones->count())
                        <table class="table">
                            <thead class="">
                                <tr>
                                    <th>
                                        Embarcaciones
                                    </th>
                                    <th>
                                        Matrícula
                                    </th>
                                    <th>
                                        Dueño
                                    </th>
                                    <th>
                                        Teléfono
                                    </th>
                                    <th>
                                        Crédito
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                    tr:hover {
                                        background-color: beige;
                                    }
                                </style>
                                @foreach ($embarcaciones as $embarcacion)
                                    <tr wire:click="seleccionEmbarcacion('{{ $embarcacion->id }}','{{ $embarcacion->nombre_emb }}','{{ $embarcacion->matricula_emb }}')"
                                        style="cursor: pointer; tr:hover{ background-color: yellow}">
                                        <td>
                                            {{ $embarcacion->nombre_emb }} <br> ({{ $embarcacion->razon_cli }})
                                        </td>
                                        <td>
                                            {{ $embarcacion->matricula_emb }}
                                        </td>
                                        <td>
                                            {{ $embarcacion->duenio_emb }}
                                        </td>
                                        <td>
                                            {{ $embarcacion->telefono_emb }}
                                        </td>
                                        <td>
                                            @if ($embarcacion->monto_credito)
                                                <button type="button" class="btn btn-outline-danger">
                                                    {{ $embarcacion->monto_credito }}
                                                </button>
                                            @endif

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
    window.addEventListener('print', event => {
        var id = event.detail.id;
        
        window.open('http://localhost/print/public/print/'+id, '_blank');

    });
</script>
