<div class="card-header">
    <h3>
        Reporte de Créditos
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
    <br>

    <div class="row">
        <div>

            <button wire:click="list_creditos" wire:loading.attr="disabled" class="btn btn-primary" type="button"> <i
                    class="fa fa-search"></i> <i wire:target="list_creditos" wire:loading.class="fa fa-spinner fa-spin"
                    aria-hidden="true"></i> Buscar</button>
        </div>

        <div style="padding-left: 1%">

            <button wire:click="default" wire:loading.attr="disabled" class="btn btn-secondary" type="button"> <i
                    class="fa fa-text"></i> <i wire:target="default" wire:loading.class="fa fa-spinner fa-spin"
                    aria-hidden="true"></i> Limpiar</button>
        </div>
        <div class="col clearfix">
            <div class="float-right">


                <button wire:click="exportarPdf" wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top"
                    title="IMPRIMIR PDF" class="btn btn-danger" type="button"> <i class="fas fa-file-pdf"></i> <i
                        wire:target="exportarPdf" wire:loading.class="fa fa-spinner fa-spin"
                        aria-hidden="true"></i></button>
            </div>

        </div>
    </div>

    <br>
</div>

<!--  Modal Buscar usuario -->
@include('livewire.reporte-credito.view.table')
<!-- Fin Modal -->
<!--  Modal Buscar usuario -->
@include('livewire.reporte-credito.view.modal.md-search-cliente')
<!-- Fin Modal -->




<script>
    window.addEventListener('close-modal-cliente', event => {
        var producto = event.detail.producto;
        $('#buscarCliente').modal('hide');

    });
</script>
