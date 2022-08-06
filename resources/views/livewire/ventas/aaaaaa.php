<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
        <div class="viewport-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb has-arrow">
                    <li class="breadcrumb-item">
                        <a href="#">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Gestión</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Reportes</li>
                </ol>
            </nav>

        </div>
        <div class="jumbotron">
            <h1 class="display-4">Reportes</h1>
            <p class="lead">Apartado de reportes generales</p>
            <hr class="my-4">
        </div>
        <?php

        require_once './controladores/ordenClienteControlador.php';
        $lista = new ordenClienteControlador();
        $clientes=$lista->listar_totales_clientes_controlador();


        ?>
        <div class="content-viewport">
            <div class="row">

                <div class="col-lg-12 equel-gid">
                    <div class="grid">
                        <div class="card">
                            <div class="card-header bg-secondary">
                                <strong>Reporte de Venta</strong>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Total de Ordenes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total=0;
                                        foreach ($clientes as $key=>$item) {
                                        $total=$total+$item["total_ordencli"];
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $key++; ?></th>
                                                <td><?php echo $item["razon_social"] ?></td>
                                                <td><?php echo $item["total_ordencli"] ?></td>
                                            </tr>

                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><strong>Total: </strong><?php echo $total; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                saas
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>