<!--Clientes-->
<div class="card-header">
    <h3>
        Listado de Clientes (Empresas)
    </h3>
    <input wire:model='search' type="text" class="form-control" placeholder="Buscar por cualquier criterio">

</div>


@if ($clientes->count())
    <div class="card-body">
        <table class="table table-striped table-sm table-responsive table-hover">
            <thead>
                <th>ID</th>
                <th>Razon</th>
                <th>Nombre</th>
                <th>Dueño de Empresa</th>
                <th>DNI</th>
                <th>RUC</th>
                <th>Tipo Cliente</th>
                <th>Persona</th>
                <th>telefono</th>
                <th>Email</th>
                <th>Acción</th>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr style="cursor: pointer;">
                        <td>{{ $cliente->id_cliente }}</td>
                        <td>{{ $cliente->razon_cli }}</td>
                        <td>{{ $cliente->nombre_cli }}</td>
                        <td>{{ $cliente->duenio_cli }}</td>
                        <td>{{ $cliente->dni_cli }}</td>
                        <td>{{ $cliente->ruc_cli }}</td>
                        <td>{{ $cliente->nombre_tipo }}</td>
                        <td>{{ $cliente->nombre_per }}</td>
                        <td>{{ $cliente->telefono_cli }}</td>
                        <td>{{ $cliente->email_cli }}</td>
                        <td colspan="1">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button wire:click="modalEmbarcacion({{ $cliente->id_cliente }})" type="button"
                                    class="btn btn-primary">
                                    <i class='fa fa-plus'></i>
                                </button>
                                <button wire:click="listaDetalle({{ $cliente->id_cliente }})" type="button"
                                    class="btn btn-primary">
                                    <i class='fa fa-eye'></i>
                                </button>
                                <button wire:click="editar({{ $cliente->id_cliente }})" type="button"
                                    class="btn btn-primary">
                                    <i class='fas fa-edit'></i>
                                </button>
                                <button wire:click="delete({{ $cliente->id_cliente }})" type="button"
                                    class="btn btn-primary">
                                    <i class='fa fa-trash'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="9">
                            <div id="{{ $cliente->id_cliente }}" style="display:none">
                                <div id="none" style="display: none" class="card">
                                    <div class="modal-header">
                                        <h5>No se encontró embarcaciones</h5>
                                        <button onclick="slideOff({{ $cliente->id_cliente }})" type="button"
                                            class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>

                                <div id="display" class="card">
                                    <div class="modal-header">
                                        <h5>Embarcaciones de <strong>{{ $cliente->nombre_cli }}</strong></h5>
                                        <button onclick="slideOff({{ $cliente->id_cliente }})" type="button"
                                            class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="card-body">

                                        <table class="table-responsive-sm table-secondary table-striped"
                                            style="table-layout: fixed; width: 100%;">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Dueño Embarcación</th>
                                                    <th>Nombre Embarcación</th>
                                                    <th>Matrícula</th>
                                                    <th>Teléfono</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($embarcaciones as $embarcacion)
                                                    <tr>
                                                        <td>{{ $embarcacion->duenio_emb }}</td>
                                                        <td>{{ $embarcacion->nombre_emb }}</td>
                                                        <td>{{ $embarcacion->matricula_emb }}</td>
                                                        <td>{{ $embarcacion->telefono_emb }}</td>
                                                        <td>

                                                                <a wire:click='deleteEmb({{$embarcacion->id}})' class="btn" >
                                                                    <i class='fa fa-trash text-dark'></i>
                                                                </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                            </div>

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>



    <div class="card-footer mx-auto">
        {{ $clientes->links() }}
    </div>
@else
    <div class="card-body">
        <strong>No se encontraron resultados</strong>
    </div>
@endif

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="modalAddEmbarcacion" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Agregar Embarcación a <strong
                        id="cliente"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group">
                        <label>Nombre de Embarcación</label>
                        <input wire:model='nombre_emb' type="text" class="form-control" id="exampleInputEmail1"
                            placeholder="Ingresar Nombre de Embarcación"></small>
                    </div>
                    <div class="form-group">
                        <label>Nombre de Dueño</label>
                        <input wire:model='duenio_emb' type="text" class="form-control" id="exampleInputEmail1"
                            placeholder="Ingresar Nombre del Dueño"></small>
                    </div>
                    <div class="form-group">
                        <label>Matrícula</label>
                        <input wire:model='matricula_emb' type="text" class="form-control" id="exampleInputEmail1"
                            placeholder="Ingresar Matrícula de Embarcación"></small>
                    </div>
                    <div class="form-group">
                        <label>Teléfono (Contacto)</label>
                        <input wire:model='telefono_emb' type="text" class="form-control" id="exampleInputEmail1"
                            placeholder="Ingresar Matrícula de Embarcación"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" wire:click='storeEmbarcacion' class="btn btn-primary">Agregar
                    Embarcación</button>
            </div>
        </div>
    </div>
</div>



<script>
    window.addEventListener('slider', event => {
        var div = '#' + event.detail.id;
        var filas = event.detail.filas;
        if (filas != 0) {
            $(div).slideDown("slow");
        } else if (filas == 0) {
            Swal.fire({
                type: 'error',
                title: 'No se encontraron embarcaciones',
                showConfirmButton: false,
                timer: 2000
            })
        }

    });
    window.addEventListener('modal', event => {
        var cliente = event.detail.cliente;
        document.getElementById("cliente").innerHTML = cliente;
        $('#modalAddEmbarcacion').modal('show');

    });
    window.addEventListener('close-modal', event => {

        $('#modalAddEmbarcacion').modal('hide');

    });


    function slideOff(id) {
        var div = '#' + id;
        $(div).slideUp("slow");
    }
</script>
