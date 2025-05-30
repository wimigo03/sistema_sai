@extends('layouts.dashboard')
@section('content')

<div class="row font-verdana-12">
    <div class="col-md-8 titulo">
        <b>MEDIDAS</b>
    </div>
    <div class="col-md-4 text-right">
     

        <a href="{{route('medidas.create')}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
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
            <table  class="table  yajra-datatable table-bordered hoverTable responsive font-verdana" style="width:80%;">
                <thead>
                    <tr class="font-verdana-11">
                        <td class="text-justify p-1"><b>N°</b></td>
                        <td class="text-justify p-1"><b>NOMBRE</b></td>
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
            ajax: "{{ route('medidas.list') }}",
            columns: [
                {data: 'DT_RowIndex',class:'text-justify p-1 font-verdana',orderable: false,searchable: false},
                {data: 'nombreumedida',name: 'nombreumedida',class:'text-justify p-1 font-verdana'},
                {data: 'btn',name: 'btn',class:'text-center p-1 font-verdana',orderable: true,searchable: true},
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

    function agregar(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        window.location.href = "{{route('medidas.create')}}";
    }
</script>

@endsection
@endsection

