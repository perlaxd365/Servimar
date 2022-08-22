<div>


        
        @include('livewire.ventas.create')

    <div class="card">
        
        @include('livewire.ventas.table')

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