@extends('layouts.admin')

@section('content')
<div class="row font-verdana-12">
    <div class="col-md-8 titulo">
        <b>GRUPO CONTABLE</b>
    </div>
    <div class="col-md-4 text-right">
       
        <a href="{{route('activo.codcont.create')}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
            <button class="btn btn-sm btn-primary font-verdana" type="button">
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
    
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="row font-verdana-sm">
    <div class="col-md-12">
        <center>
            <table class="table-bordered yajra-datatable display compact hoverTable" style="width:100%;">
                <thead class="font-courier">
                    <tr>
                        <th class="text-center p-1 font-weight-bold" style="background-color: white;"><b>N°</b></th>
                        <th class="text-center p-1 font-weight-bold" style="background-color: white;"><b>CODCONT</b></th>
                        <th class="text-center p-1 font-weight-bold" style="background-color: white;"><b>NOMBRE</b></th>
                        <th class="text-center p-1 font-weight-bold" style="background-color: white;"><b>VIDAUTIL</b></th>
                        <th class="text-center p-1 font-weight-bold" style="background-color: white;"><b>feult</b></th>
                        <th class="text-center p-1 font-weight-bold" style="background-color: white;"><b>usuar</b></th>
                        <th class="text-center p-1 font-weight-bold" style="background-color: white;"><i class="fa fa-bars" aria-hidden="true"></i></th>
                        <th class="text-center p-1 font-weight-bold" style="background-color: white;"><i class="fa fa-bars" aria-hidden="true"> AUXILIARES</i></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </center>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function() {
        var table = $('.yajra-datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('activo.codcont.list') }}",
            columns: [
                {
                    data: 'codcont',
                    name: 'codcont',
                    orderable: false,
                    searchable: false,
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'codcont',
                    name: 'codcont',
                    class: 'text-justify p-1 font-verdana',
                    "visible": false
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'vidautil',
                    name: 'vidautil',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'feult',
                    name: 'feult',
                    class: 'text-justify p-1 font-verdana',
                    "visible": false
                },
                {
                    data: 'usuar',
                    name: 'usuar',
                    class: 'text-justify p-1 font-verdana',
                    "visible": false
                },
                {
                    data: 'btn',
                    name: 'btn',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'btn2',
                    name: 'btn2',
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
            }
        });
    });
</script>
@endsection
