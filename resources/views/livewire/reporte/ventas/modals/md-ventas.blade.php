
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="buscarOperario"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
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
                    <input wire:model='search' type="text" class="form-control"
                        placeholder="Buscar por cualquier criterio">
                </div>
                <div class="table-responsive">
                    @if ($operarios->count())
                        <table class="table">
                            <thead class="">
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        DNI
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Punto
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                    tr:hover {
                                        background-color: beige;
                                    }
                                </style>
                                @foreach ($operarios as $operario)
                                    <tr wire:click="seleccionarOperario('{{ $operario->id }}','{{ $operario->name }}')"
                                        style="cursor: pointer; tr:hover{ background-color: yellow}">
                                        <td>
                                            {{ $operario->id }} 
                                        </td>
                                        <td>
                                            {{ $operario->name }} 
                                        </td>
                                        <td>
                                            {{ $operario->dni }}
                                        </td>
                                        <td>
                                            {{ $operario->email }}
                                        </td>
                                        <td>
                                            
                                            <span class="badge badge-warning">
                                                {{ $operario->descripcion }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="card-footer container justify-content-center d-inline-flex ">
                            {{ $operarios->links() }}
                        </div>
                    @else
                        <div class="card-body">
                            <strong>No se encontraron resultados</strong>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='quitarPersona' data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>


