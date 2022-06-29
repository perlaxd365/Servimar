<div>


    <div class="card">
        
        @include('livewire.product.table')

    </div>
    <div class="card">
        
        @include('livewire.product.tableKardex')

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