<div class="card-header">

    <h3>
        Nuevo Pago (Empresa)
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
</div>
<div class="card-body">

    <div class="form-row">
        <div class="form-group col-md-12">
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
        <div class="form-group col-md-12">
            <label for="">Pago</label>
            <input wire:model='monto_pago' type="number" class="form-control" placeholder="Ingresar Pago">
        </div>
    </div>
    <br>
    <button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary" type="button"> <i
            class="fa fa-plus-circle"></i> <i wire:target="store" wire:loading.class="fa fa-spinner fa-spin"
            aria-hidden="true"></i> Agregar</button>
    <br>
</div>


<!-- Modal -->
<div wire:ignore.self class="modal fade" id="buscarCliente"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Buscar</h5>
                <button type="button"  wire:click='defaulPage' class="close" data-dismiss="modal" aria-label="Close">
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
                                    <tr wire:click="seleccionarCliente('{{ $cliente->id_cliente }}','{{ $cliente->razon_cli }}','{{ $cliente->ruc_cli }}')"
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
                    <button type="button" class="btn btn-secondary" wire:click='defaulPage' data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fin Modal -->

<script>
    window.addEventListener('close-modal', event => {
        var producto = event.detail.producto;
        $('#buscarCliente').modal('hide');

    });
    window.addEventListener('actualizar-pagina', event => {
        location.reload();
    });
</script>
