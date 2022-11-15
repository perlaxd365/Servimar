
<!-- Modal -->
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
                    <input wire:model='search_cliente' type="text" class="form-control"
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