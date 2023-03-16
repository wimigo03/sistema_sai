@extends('layouts.admin')
@section('content')


    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>ARCHIVOS -- </b><b style='color:orange'>{{ $idd->nombrearea }} </b>--
        </div>
        <div class="col-md-4 text-right titulo">
            @can('archivos_create')
                <a href="{{ route('archivos2.create') }}" class="tts:left tts-slideIn tts-custom"
                    aria-label="Agregar Solicitud">
                    <button class="btn btn-sm btn-success font-verdana" type="button">Agreg.Archivo.
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>
            @endcan





        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table class="table-bordered yajra-datatable hoverTable responsive font-verdana" style="width:100%;">
                    <thead>
                        <tr>
                            <td class="text-justify p-1"><b>N°</b></td>
                            <td class="text-justify p-1"><b>GESTION</b></td>
                            <td class="text-justify p-1"><b>FECHA REC./ENV.</b></td>
                            <td class="text-justify p-1"><b>NUM.DOC.</b></td>
                            <td class="text-justify p-1"><b>REFERENCIA</b></td>
                            <td class="text-justify p-1"><b>TIPO</b></td>
                            <td class="text-center p-1 font-weight-bold">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </td>
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
ajax: "{{ route('archivos2.index') }}",
columns: [
    {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},

    {data: 'gestion',name: 'a.gestion',class:'text-justify p-1 font-verdana'},

    {data: 'fecha',name: 'a.fecha',class:'text-justify p-1 font-verdana'},

    { data: 'nombrearchivo',name: 'a.nombrearchivo',class:'text-justify p-1 font-verdana'},

    {data: 'referencia',name: 'a.referencia',class:'text-justify p-1 font-verdana'},

    {data: 'nombretipo',name: 't.nombretipo',class:'text-justify p-1 font-verdana'},

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
