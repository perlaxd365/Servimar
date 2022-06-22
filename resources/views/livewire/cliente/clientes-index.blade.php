<div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="card">
        <div class="card-header">
            @include('livewire.cliente.' . $view)
        </div>
    </div>
    <?php 
    $cliente='';
    $embarcacion='';
    $table=='cliente'?$cliente='active':$embarcacion='active'
    ?>
    <div class="card">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{$cliente}}" wire:click='cliente' id="home-tab" data-toggle="tab" href="#home" role="tab"
                    aria-controls="home" aria-selected="true">Clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{$embarcacion}}" wire:click='embarcacion' id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Embarcaciones</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            @include('livewire.cliente.table-' . $table)
        </div>






    </div>


</div>

<script type="text/javascript">
    window.addEventListener('respuesta', event => {
        let res = event.detail.res;
        Swal.fire({
            type: 'success',
            title: res,
            showConfirmButton: false,
            timer: 2000
        })
    });
</script>
