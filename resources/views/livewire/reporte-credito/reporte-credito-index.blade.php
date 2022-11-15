<div>


    <div class="card">
        
        @include('livewire.reporte-credito.view.create')
 
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
    window.addEventListener('error', event => {
        let res = event.detail.res;
        Swal.fire({
            type: 'warning',
            title: res,
            showConfirmButton: false,
            timer: 2000
        })
    });
 </script>