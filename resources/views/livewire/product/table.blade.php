<div class="card-header">
    <h3>
        Listado de Productos
    </h3>
    <input wire:model='search' type="text" class="form-control" placeholder="Buscar">
</div>

@if ($productos->count())
    <div class="card-body">
        <div class="card-body">
            <table class="table table-striped table-sm table-responsive-sm">
                <thead>
                    <th>ID</th>
                    <th>Sede</th>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Unidad</th>
                    <th>Acción</th>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->id_producto }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ $producto->nombre_pro }}</td>
                            <td>{{ $producto->stock_pro }}</td>
                            <td>{{ $producto->unidad_pro }}</td>
                            <td colspan="1">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button wire:click="modalAdd({{ $producto->id_producto }})" type="button"
                                        class="btn btn-secondary">
                                        <i class='fa fa-plus-square'></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary">
                                        <i class='fa fa-minus-square'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="modalStock" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Agregar a  <strong
                            id="producto"></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <label></label>
                            <input wire:model='stock_pro' type="text" class="form-control" id="exampleInputEmail1"
                                placeholder="Ingresar stock"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click='storeEmbarcacion' class="btn btn-primary">Agregar
                        </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer mx-auto">
        {{ $productos->links() }}
    </div>
@else
    <div class="card-body">
        <strong>No se encontraron resultados</strong>
    </div>
@endif

<script>
    
    window.addEventListener('modal', event => {
        var producto = event.detail.producto;
        document.getElementById("producto").innerHTML = producto;
        $('#modalStock').modal('show');

    });
    window.addEventListener('close-modal', event => {

        $('#modalStock').modal('hide');

    });
</script>