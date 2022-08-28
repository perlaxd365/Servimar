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
        <div class="form-group col-md-12">
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

                <button wire:click="exportar" wire:loading.attr="disabled"  data-toggle="tooltip" data-placement="top" title="IMPRIMIR EXCEL" class="btn btn-success" type="button"> <i
                        class="fas fa-file-excel"></i> <i wire:target="exportar"
                        wire:loading.class="fa fa-spinner fa-spin" aria-hidden="true"></i></button>

                <button wire:click="exportar" wire:loading.attr="disabled"  data-toggle="tooltip" data-placement="top" title="IMPRIMIR PDF" class="btn btn-danger" type="button"> <i
                        class="fas fa-file-pdf"></i> <i wire:target="exportar"
                        wire:loading.class="fa fa-spinner fa-spin" aria-hidden="true"></i></button>
            </div>

        </div>
    </div>

    <br>
</div>

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
</script>
