@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>SOLICITUDES PENDIENTES</b>
    </div>
    <div class="col-md-4 text-right">
    
            <a href="{{ route('combustibles.pedido.index2') }}" class="tts:left tts-slideIn tts-custom" aria-label="ir a solicitudes aprobadas">
                <button class="btn btn-sm btn-success font-verdana" type="button" >SOLICITUDES APROBADAS
                    &nbsp;<i class="fa-solid fa-thumbs-up" style="font-size:14px"></i>&nbsp;
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
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>OBJETO</b></td>
                                    <td class="text-justify p-1"><b>AREA</b></td>
                                    <td class="text-justify p-1"><b>PROVEEDOR</b></td>
                                    <td class="text-justify p-1"><b>PREVENTIVO</b></td>
                                    <td class="text-justify p-1"><b>NRO.COMPRA</b></td>
                                    <td class="text-justify p-1"><b>ESTADO</b></td>
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
        ajax: "{{ route('combustibles.pedido.index') }}",
        columns: [
            {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},

            { data: 'objeto',name: 'c.objeto',class:'text-justify p-1 font-verdana'},

            {data: 'nombrearea',name: 'a.nombrearea',class:'text-justify p-1 font-verdana'},

            {data: 'nombreproveedor',name: 'p.nombreproveedor',class:'text-justify p-1 font-verdana'},

            {data: 'preventivo',name: 'c.preventivo',class:'text-justify p-1 font-verdana'},

            {data: 'numcompra',name: 'c.numcompra',class:'text-justify p-1 font-verdana'},
            {data: 'estadocompracomb',name: 'c.estadocompracomb',class:'text-justify p-1 font-verdana'},


            {data: 'btn', name: 'btn', orderable: false, searchable: false },

             {data: 'btn2', name: 'btn2', orderable: false, searchable: false },

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
