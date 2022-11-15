<div class="card-header">
    <h3>
        Reporte de Ventas Diarias
    </h3>
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
            <label for="inputEmail4">Punto</label>
            <select wire:model="id_sede" class="form-control" name="" id="">
                <option value="">Seleccionar Punto</option>
                @foreach ($sedes as $sede)
                    <option value="{{ $sede->descripcion }}">{{ $sede->descripcion }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="inputEmail4">Tipo de Pago</label>
            <select wire:model="id_tipo_pago" class="form-control" name="" id="">
                <option value="">Seleccionar Tipo de Pago</option>
                @foreach ($tipoPagos as $tipo)
                    <option value="{{ $tipo->id_tipo_pago }}">{{ $tipo->nombre_tipo_pago }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="">Cliente (Empresa)</label>
            <div class="row">
                <div class="col-8">
                    <input wire:model='razon_cli' readonly type="text" class="form-control"
                        placeholder="Seleccionar Cliente">
                    <input wire:model='id_cliente' type="hidden" class="form-control">
                </div>
                <div class="col-4">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#buscarCliente">Buscar
                        Cliente</button>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="">Operarios</label>
            <div class="row">
                <div class="col-8">
                    <input wire:model='name_operario' readonly type="text" class="form-control"
                        placeholder="Seleccionar Operario">
                    <input wire:model='id_operario' type="hidden" class="form-control">
                </div>
                <div class="col-4">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#buscarOperario">Buscar
                        Operario</button>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="">Fecha inicio</label>
            <input wire:model='fecha_inicio' class="date form-control" type="date">
        </div>
        <div class="form-group col-md-6">
            <label for="">Fecha Fin</label>
            <input wire:model='fecha_fin' class="date form-control" type="date">
        </div>
    </div>
    <br>

    <div class="row">
        <div>

            <button wire:click="listVentas" wire:loading.attr="disabled" class="btn btn-primary" type="button"> <i
                    class="fa fa-search"></i> <i wire:target="listVentas" wire:loading.class="fa fa-spinner fa-spin"
                    aria-hidden="true"></i> Buscar</button>
        </div>

        <div style="padding-left: 1%">

            <button wire:click="default" wire:loading.attr="disabled" class="btn btn-secondary" type="button"> <i
                    class="fa fa-text"></i> <i wire:target="default" wire:loading.class="fa fa-spinner fa-spin"
                    aria-hidden="true"></i> Limpiar</button>
        </div>
        <div class="col clearfix">
            <div class="float-right">

                <button wire:click="exportarExcel" wire:loading.attr="disabled"  data-toggle="tooltip" data-placement="top" title="IMPRIMIR EXCEL" class="btn btn-success" type="button"> <i
                        class="fas fa-file-excel"></i> <i wire:target="exportarExcel"
                        wire:loading.class="fa fa-spinner fa-spin" aria-hidden="true"></i></button>

                <button wire:click="exportarPdf" wire:loading.attr="disabled"  data-toggle="tooltip" data-placement="top" title="IMPRIMIR PDF" class="btn btn-danger" type="button"> <i
                        class="fas fa-file-pdf"></i> <i wire:target="exportarPdf"
                        wire:loading.class="fa fa-spinner fa-spin" aria-hidden="true"></i></button>
            </div>

        </div>
    </div>

    <br>
</div>

<!-- Modal buscar cliente -->
<div wire:ignore.self class="modal fade" id="buscarCliente"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Buscar</h5>
                <button type="button"  wire:click='defaultCliente' class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group col-md-12">
                    <input wire:model='search' type="text" class="form-control"
                        placeholder="Buscar por razón o ruc">
                </div>
                <div class="table-responsive">
                    @if ($clientes->count())
                        <table class="table">
                            <thead class="">
                                <tr>
                                    <th>
                                        Razón Social
                                    </th>
                                    <th>
                                        Ruc
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                    tr:hover {
                                        background-color: beige;
                                    }
                                </style>
                                @foreach ($clientes as $cliente)
                                    <tr wire:click="seleccionarCliente('{{ $cliente->id_cliente }}','{{ $cliente->razon_cli }}','{{ $cliente->duenio_cli }}')"
                                        style="cursor: pointer; tr:hover{ background-color: yellow}">
                                        <td>
                                            {{ $cliente->razon_cli }} <br> ({{ $cliente->duenio_cli }})
                                        </td>
                                        <td>
                                            {{ $cliente->ruc_cli }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="card-footer container justify-content-center d-inline-flex ">
                            {{ $clientes->links() }}
                        </div>
                    @else
                        <div class="card-body">
                            <strong>No se encontraron resultados</strong>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='defaultCliente' data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fin Modal -->
<!--  Modal Buscar usuario -->
@include('livewire.reporte.ventas.table-ventas')
<!-- Fin Modal -->

<!--  Modal Buscar usuario -->
@include('livewire.reporte.ventas.modals.md-ventas')
<!-- Fin Modal -->
<!--  Modal Buscar usuario -->
@include('livewire.reporte.ventas.modals.md-detalle-ventas')
<!-- Fin Modal -->


<script>
    window.addEventListener('close-modal', event => {
        var producto = event.detail.producto;
        $('#buscarOperario').modal('hide');

    });
    window.addEventListener('close-modal-cliente', event => {
        var producto = event.detail.producto;
        $('#buscarCliente').modal('hide');

    });
    window.addEventListener('actualizar-pagina', event => {
        location.reload();
    });
</script>
