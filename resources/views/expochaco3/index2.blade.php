@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>Solicitudes Aprobadas</b>
    </div>
    <div class="col-md-4 text-right">


            <a href="{{ route('expochaco.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="CREAR NUEVO">
                <button class="btn btn-sm btn-info font-verdana" type="button" >Volver a Pendientes
                    &nbsp;<i class="fa-solid fa-arrow-circle-left" style="font-size:14px"></i>&nbsp;
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
                        <table class="table-bordered yajra-datatable hoverTable responsive font-verdana" style="width:100%;">
                            <thead class="font-courier">
                                <tr>
                                    <td class="text-justify p-1"><b>Nombre</b></td>
                                    <td class="text-justify p-1"><b>Ci</b></td>
                                    <td class="text-justify p-1"><b>Asociacion</b></td>
                                    <td class="text-justify p-1"><b>Correo</b></td>
                                    <td class="text-justify p-1"><b>Distrito/Ciudad</b></td>
                                    <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                                    <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                                    <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
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
        ajax: "{{ route('expochaco.index2') }}",
        columns: [


            { data: 'nombresolicitud',name: 's.nombresolicitud',class:'text-justify p-1 font-verdana'},

            {data: 'ci',name: 's.ci',class:'text-justify p-1 font-verdana'},

            {data: 'asociacionsol',name: 's.asociacionsol',class:'text-justify p-1 font-verdana'},

            {data: 'correosol',name: 's.correosol',class:'text-justify p-1 font-verdana'},

            {data: 'ciudad',name: 's.ciudad',class:'text-justify p-1 font-verdana'},

            {data: 'btn', name: 'btn', orderable: false, searchable: false },

            {data: 'btn4', name: 'btn4', orderable: false, searchable: false },

            {data: 'btn5', name: 'btn5', orderable: false, searchable: false },
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
