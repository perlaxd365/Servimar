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
        background-color: #14DB00;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #14DB00;
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
                        <strong>{{ $sede }}</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Producto</strong> : {{ $producto->nombre_pro }}</li>
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
{{-- Validando la jornada --}}
@if ($estado_jornada == false)
    <div class="card">
        <div class="card-header alert-warning">
            Iniciar Jornada
        </div>
        <div class="card-body">
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
            <h5 class="card-title">Iniciar la jornada <small>(ventas)</small> de hoy</h5>
            <div class="card-body  form-row">
                @if ($punto_paita)
                    <div class="form-group col-md-6">
                        <label for="">Indicar valor de contómetro A</label>
                        <input wire:model='contometro_a_inicio' type="text" class="form-control"
                            placeholder="Ingresar el número que marca en el contómetro A">
                        <small class="text-danger">Introducir al iniciar la jornada de hoy</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Indicar el valor de contómetro B</label>
                        <input wire:model='contometro_b_inicio' type="text" class="form-control"
                            placeholder="Ingresar el número que marca en el contómetro B">
                        <small class="text-danger">Introducir al iniciar la jornada de hoy</small>
                    </div>
                @else
                    <div class="form-group col-md-6">
                        <label for="">Indicar valor de contómetro</label>
                        <input wire:model='contometro_1_inicio' type="text" class="form-control"
                            placeholder="Ingresar el número que marca en el contómetro">
                        <small class="text-danger">Introducir al iniciar la jornada de hoy</small>
                    </div>
                @endif
            </div>
            <a href="#" wire:click='iniciarJornada' class="btn btn-success">Iniciar</a>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header alert-warning">
            Finalizar Jornada de Hoy
        </div>
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
        <div class="card-body">
            <h5 class="card-title">Cerrar las ventas para autoenviar reporte</h5>
            <div class="card-body  form-row">
                @if ($punto_paita)
                    <div class="form-group col-md-6">
                        <label for="">Indicar valor de contómetro A</label>
                        <input wire:model='contometro_a_fin' type="text" class="form-control"
                            placeholder="Ingresar el número que marca en el contómetro A">
                        <small class="text-danger">Introducir al finalizar la jornada de hoy</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Indicar el valor de contómetro B</label>
                        <input wire:model='contometro_b_fin' type="text" class="form-control"
                            placeholder="Ingresar el número que marca en el contómetro B">
                        <small class="text-danger">Introducir al finalizar la jornada de hoy</small>
                    </div>
                @else
                    <div class="form-group col-md-6">
                        <label for="">Indicar valor de contómetro</label>
                        <input wire:model='contometro_1_fin' type="text" class="form-control"
                            placeholder="Ingresar el número que marca en el contómetro">
                        <small class="text-danger">Introducir al finalizar la jornada de hoy</small>
                    </div>
                @endif
            </div>
            <a href="#" wire:click='finalizarJornada' class="btn btn-warning">Finalizar</a>
        </div>
    </div>
    <ul class="nav nav-pills mb-3 card-body" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?php if ($view == 'create') {
                echo 'active';
            } ?>" id="crear-venta" wire:click="crearVentaView" data-toggle="pill"
                href="#pills-home" role="tab"aria-controls="pills-home" aria-selected="true">Crear Venta</a>
        </li>
        @if ($punto_paita)
            <li class="nav-item">
                <a class="nav-link <?php if ($view == 'create_venta_agua') {
                    echo 'active';
                } ?>" id="crear-venta-agua" wire:click="crearVentaAguaView"
                    data-toggle="pill" href="#pills-home" role="tab"aria-controls="pills-home"
                    aria-selected="true">Venta Agua</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link <?php if ($view == 'list') {
                echo 'active';
            } ?>" id="ver-ventas" wire:click="listarVentaView" data-toggle="pill"
                href="#pills-profile" role="tab"aria-controls="pills-profile" aria-selected="false">Ver
                Ventas</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade <?php if ($view == 'create') {
            echo 'show active';
        } ?>" id="pills-home" role="tabpanel"
            aria-labelledby="crear-venta">

            <div>
                <div class="card">
                    <div class="card-header  alert-secondary">
                        <h5>Datos de Embarcación</h5>
                    </div>
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
                    <div class="card-body">
                        <label for="">Embarcacion</label>
                        <div class="row">
                            <div class="col-8">
                                <input wire:model='nombre_emb' readonly type="text" class="form-control"
                                    placeholder="Seleccionar Embarcación">
                                <input wire:model='id_emb' type="hidden" class="form-control">
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary" data-toggle="modal"
                                    data-target="#buscarEmbarcacion">Buscar
                                    Embarcación</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header  alert-secondary">
                        <h5>Datos de Venta</h5>
                    </div>
                    <div class="card-body  form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Galones</label>
                            <input wire:model='galonaje_venta' wire:keyup='calcularTotal'
                                wire:keypress='calcularTotal' wire:keydown='calcularTotal' autocomplete="off"
                                type="number" Step="0" class="form-control solo-numero"
                                placeholder="Ingresar Cantidad de Galones">
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
                            <label for="inputEmail4">Precio x Galón</label>
                            <input wire:model='precio_galon' wire:keyup='calcularTotal' wire:keypress='calcularTotal'
                                wire:keydown='calcularTotal' autocomplete="off" type="number" Step="0"
                                class="form-control solo-numero" placeholder="Ingresar Cantidad de Galones">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Tipo de Pago</label>
                            <select wire:model="idtipopago" class="form-control" name="" id="">
                                <option value="">Seleccionar Tipo de Pago</option>
                                @foreach ($tipoPagos as $tipo)
                                    <option value="{{ $tipo->id_tipo_pago }}">{{ $tipo->nombre_tipo_pago }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6"
                            style="@if ($mostrarPrecioFront) display:block @else display:none @endif">
                            <label for="inputEmail4">Precio</label>
                            <input readonly wire:model='precio_venta' type="number" autocomplete="off"
                                Step="0" class="form-control solo-numero" id="exampleInputEmail1"
                                placeholder="Ingresar Precio">
                            <br>
                            <label for="inputEmail4">Mostrar Precio</label>
                            <label class="switch" style="size: 4cm">
                                <input wire:model="mostrarPrecio" type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6"
                            style="@if ($mostrarPrecioFront && $depositoBanco) display:block @else display:none @endif">
                            <label for="inputEmail4">Cuenta a depositar</label>
                            <select wire:model="nombre_banco_venta" class="form-control" name=""
                                id="">
                                <option value="">Seleccionar Banco</option>
                                <option value="BCP">BCP</option>
                                <option value="BBVA">BBVA</option>
                                <option value="SCOTIABANK">SCOTIABANK</option>
                                <option value="SCOTIABANK">INTERBANK</option>
                            </select>
                            <label for="inputEmail4">Número de Operación</label>
                            <input wire:model='num_operacion_venta' autocomplete="off"
                                type="text" class="form-control" placeholder="Ingresar el número de la operación">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header alert-secondary">
                        <h5>Datos de Contometro</h5>
                    </div>
                    <div class="container">

                    </div>
                    <div class="card-body  form-row">
                        @if ($punto_paita)
                            <div class="form-group col-md-6">
                                <label for="">Indicar valor de contómetro A</label>
                                <input wire:model='contometro_a' type="text" class="form-control"
                                    placeholder="Ingresar el número que marca en el contómetro A">
                                <small class="text-danger">Introducir después del despacho de petroleo</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Indicar el valor de contómetro B</label>
                                <input wire:model='contometro_b' type="text" class="form-control"
                                    placeholder="Ingresar el número que marca en el contómetro B">
                                <small class="text-danger">Introducir después del despacho de petroleo</small>
                            </div>
                        @else
                            <div class="form-group col-md-6">
                                <label for="">Indicar valor de contómetro</label>
                                <input wire:model='contometro_1' type="text" class="form-control"
                                    placeholder="Ingresar el número que marca en el contómetro">
                                <small class="text-danger">Introducir después del despacho de petroleo</small>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header  alert-secondary">
                        <h5>Datos de Referencia</h5>
                    </div>
                    <div class="card-body  form-row">
                        <div class="form-group col-md-6">
                            <label for="">Nombres y Apellidos</label>
                            <input wire:model='nombre_ref_venta' type="text" class="form-control"
                                placeholder="Ingresar Nombres de Referencia">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">DNI</label>
                            <input wire:model='dni_ref_venta' minlength="8" type="text" class="form-control"
                                placeholder="Ingresar DNI de Referencia">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Teléfono</label>
                            <input wire:model='telefono_ref_venta' type="text" class="form-control"
                                placeholder="Ingresar teléfono de Referencia">
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header  alert-secondary">
                        <h4>Observaciones</h4>
                    </div>
                    <div class="card-body  form-row">
                        <div class="form-group col-md-12">
                            <label for="">Especificar Observación</label>
                            <textarea wire:model='observacion_venta' class="form-control" id="" cols="5" rows="5"
                                placeholder="Ingresar Observación">
    
                    </textarea>
                        </div>
                        <div class="container">
                            <div class="card-body form-row">
                                <button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary"
                                    type="button">
                                    <i class="fa fa-plus-circle"></i> <i wire:target="store"
                                        wire:loading.class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                    Registrar
                                    Venta</button>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="tab-pane fade <?php if ($view == 'create_venta_agua') {
            echo 'show active';
        } ?>" id="pills-home" role="tabpanel"
            aria-labelledby="crear-venta-agua">

            <div>
                <div class="card">
                    <div class="card-header  alert-secondary">
                        <h5>Datos de Embarcación</h5>
                    </div>
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
                    <div class="card-body">
                        <label for="">Embarcacion</label>
                        <div class="row">
                            <div class="col-8">
                                <input wire:model='nombre_emb' readonly type="text" class="form-control"
                                    placeholder="Seleccionar Embarcación">
                                <input wire:model='id_emb' type="hidden" class="form-control">
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary" data-toggle="modal"
                                    data-target="#buscarEmbarcacion">Buscar
                                    Embarcación</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header  alert-secondary">
                        <h5>Datos de venta</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="" for="inlineFormInputGroup">Ingresar Venta de agua</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Cilindros</div>
                                    </div>
                                    <input wire:model='monto_agua' type="number" class="form-control"
                                        id="inlineFormInputGroup" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="" for="inlineFormInputGroup">Ingresar Contómetro</label>
                                <input wire:model='contometro_agua' type="text" class="form-control"
                                    id="inlineFormInputGroup" placeholder="Ingresa contometro">
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="card-body form-row">
                            <button wire:click="store_agua" wire:loading.attr="disabled" class="btn btn-primary"
                                type="button">
                                <i class="fa fa-plus-circle"></i> <i wire:target="store_agua"
                                    wire:loading.class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                Registrar
                                Venta</button>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="card">

                    <div class="card-header  alert-secondary">
                        <h5>Ventas de agua</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Embarcación</th>
                                    <th scope="col">Agua</th>
                                    <th scope="col">Contómetro</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (count($listaAgua) > 0)

                                    @foreach ($listaAgua as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id_venta_agua }}</th>
                                            <td>{{ $item->nombre_emb }}</td>
                                            <td>{{ $item->monto_agua }}</td>
                                            <td>{{ $item->contometro_agua }}</td>
                                            <td>{{ $item->fecha_venta_agua }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr style="cursor:pointer;">
                                        <th colspan="12" style="background-color: bisque" scope="row">No hay
                                            resultados</th>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- Area de ventas --}}
        <div class="tab-pane fade <?php if ($view == 'list') {
            echo 'show active';
        } ?>" id="pills-profile" role="tabpanel"
            aria-labelledby="ver-ventas">

            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Lista de Ventas
                        </h4>
                        <input wire:model='searchVenta' type="text" class="form-control" placeholder="Buscar">
                    </div>

                    @if ($ventas->count())
                        <div class="card-body">
                            <div class="card-body">
                                <table class="table table-striped table-sm table-responsive-sm">
                                    <thead>
                                        <th>ID</th>
                                        <th>E/P</th>
                                        <th>MATRÍCULA</th>
                                        <th>TIPO PAGO</th>
                                        <th>HORA</th>
                                        <th>PRECIO X GALÓN</th>
                                        <th>GALONES</th>
                                        <th>PAGO</th>
                                        <th>VER</th>
                                        <th>IMPRIMIR</th>
                                        <th>ELIMINAR</th>
                                    </thead>
                                    <tbody>
                                        <?php $totalGalones = 0;
                                        $totalVenta = 0; ?>
                                        @foreach ($ventas as $venta)
                                            <?php $totalGalones = $totalGalones + $venta->galonaje_venta; ?>
                                            <?php $totalVenta = $totalVenta + $venta->precio_venta; ?>
                                            <tr>
                                                <td>{{ $venta->id_venta }}</td>
                                                <td>{{ $venta->nombre_emb }}</td>
                                                <td>{{ $venta->matricula_emb }}</td>
                                                <td>{{ $venta->nombre_tipo_pago }}</td>
                                                <td>{{ Str::substr($venta->fecha_venta, 10, 6) . Str::substr($venta->fecha_venta, 19, 3) }}
                                                </td>
                                                <td>S/ {{ $venta->precio_x_galon_venta }}</td>
                                                <td>{{ $venta->galonaje_venta }}</td>
                                                <td>S/ {{ $venta->precio_venta }}</td>
                                                <td  class="text-center">
                                                    <button wire:click="modalDetalle({{ $venta->id_venta }})"
                                                        type="button" class="btn btn-outline-info"
                                                        data-toggle="modal" data-target="#detalleVenta">
                                                        <i class='fas fa-eye'></i>
                                                    </button>

                                                </td>
                                                <td class="text-center">
                                                    <button wire:click="print({{ $venta->id_venta }})" type="button"
                                                        class="btn btn-outline-warning">

                                                        <i class='fa fa-print'></i>
                                                    </button>
                                                </td>
                                                <td  class="text-center">
                                                    <button wire:click="eliminar({{ $venta->id_venta }})" type="button"
                                                        class="btn btn-outline-danger">

                                                        <i class='fa fa-trash'></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>TOTAL:</strong></td>
                                            <td>{{ $totalGalones }}</td>
                                            <td>S/{{ $totalVenta }}</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
@endif
{{-- Fin Validando la jornada --}}

@include('livewire.ventas..modals.md_detalle_venta')




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
                                            @if ($embarcacion->galones_credito)
                                                <span class="badge badge-warning">
                                                    Crédito - Galones
                                                </span>
                                                <span class="badge badge-danger">
                                                    {{ $embarcacion->galones_credito }}
                                                </span>
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

<!-- Fin Modal -->



<script>
    window.addEventListener('actualizar-pagina', event => {
        location.reload();
    });
    window.addEventListener('close-modal', event => {
        var producto = event.detail.producto;
        $('#buscarEmbarcacion').modal('hide');

    });
    window.addEventListener('print', event => {
        var id = event.detail.id;
        var URL = 'http://localhost/print/public/print/' + id
        window.open(URL, 'Impresión',
            'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=300,height=200,left = 390,top = 50'
        );


    });
</script>
