@extends('layouts.dashboard')
@section('content')

<div class="row font-verdana-12">

    <div class="col-md-8 titulo">
        <b>IMAGENES</b>
    </div>

    <div class="col-md-4 text-right">

      

            <a href="{{route('activo.imagenes.create')}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
                <button class="btn btn-sm btn-primary font-verdana" type="button" >
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>

            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

 

    </div>

         <div class="col-md-12">
            <hr class="hrr">
         </div>

</div>
        <div class="row">
             <div class="col-md-12">
                <center>
                        <table class="table-bordered yajra-datatable hoverTable" style="width:100%;">
                            <thead class="font-courier">
                                <tr>
                                    <td class="text-center p-1 font-weight-bold"><b>N°</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>IMAGEN ACTIVO</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>NOMBRE IMAGEN</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>RUTA IMAGEN</b></td>
                                    <td class="text-center p-1 font-weight-bold">
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                    </td>


                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                  </center>
             </div>
        </div>

@section('scripts')

<script type="text/javascript">
$(function() {

    var table = $('.yajra-datatable').DataTable({


        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: "{{ route('activo.imagenes.list') }}",
        columns: [

            {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},

            {
                data: 'imagenactivos', name: 'imagenactivos',class:'text-justify p-1 font-verdana' },
            {
                data: 'nombreimagen', name: 'nombreimagen',class:'text-justify p-1 font-verdana'},
            {
                data: 'rutaimagen', name: 'rutaimagen',class:'text-justify p-1 font-verdana'},
                
           

            {
                data: 'btn',
                name: 'btn',
                orderable: true,
                searchable: true
            },
        ],



language: {
"decimal": "",
"emptyTable": "No hay información",
"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
"infoFiltered": "(Filtrado de _MAX_ total entradas)",
"infoPostFix": "",
"thousands": ",",
"lengthMenu": "Mostrar _MENU_ Entradas",
"loadingRecords": "Cargando...",
"processing": "Procesando...",
"search": "Buscar:",
"zeroRecords": "Sin resultados encontrados",
"paginate": {
    "first": "Primero",
    "last": "Ultimo",
    "next": "Siguiente",
    "previous": "Anterior"
}
},

    });

});
</script>

@endsection
@endsection
