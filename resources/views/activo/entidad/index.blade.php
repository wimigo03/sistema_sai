@extends('layouts.dashboard')
@section('content')

<div class="row font-verdana-12">
    <div class="col-md-8 titulo">
        <b>ENTIDADES</b>
    </div>
    <div class="col-md-4 text-right">
       
        <a href="{{ route('activo.entidad.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
            <button class="btn btn-sm btn-primary font-verdana" type="button">
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
       
    </div>
</div>

<div class="row font-verdana-sm">
    <div class="col-md-12">
        <center>
            <table class="table-bordered yajra-datatable hoverTable" style="width:100%;">
                <thead class="font-courier">
                    <tr>
                        <th class="text-center p-1 font-weight-bold"><b>N°</b></th>
                        <th class="text-center p-1 font-weight-bold"><b>GESTION</b></th>
                        <th class="text-center p-1 font-weight-bold"><b>ENTIDAD</b></th>
                        <th class="text-center p-1 font-weight-bold"><b>DESCRIPCION</b></th>
                        <th class="text-center p-1 font-weight-bold"><b>SIGLA</b></th>
                        <th class="text-center p-1 font-weight-bold"><b>SECTOR ENTIDAD</b></th>
                        <th class="text-center p-1 font-weight-bold"><b>SUB SECTOR EMT</b></th>
                        <th class="text-center p-1 font-weight-bold"><b>AREA ENTIDAD</b></th>
                        <th class="text-center p-1 font-weight-bold"><b>SUBAREA ENT</b></th>
                        <th class="text-center p-1 font-weight-bold"><b>NIVEL INST</b></th>
                        <th class="text-center p-1 font-weight-bold"><i class="fa fa-bars" aria-hidden="true"></i></th>
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
            ajax: "{{ route('activo.entidad.list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'gestion',
                    name: 'gestion',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'entidad',
                    name: 'entidad',
                    class: 'text-justify p-1 font-verdana',
                    "visible": false
                },
                {
                    data: 'desc_ent',
                    name: 'desc_ent',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'sigla_ent',
                    name: 'sigla_ent',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'sector_ent',
                    name: 'sector_ent',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'subsec_ent',
                    name: 'subsec_ent',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'area_ent',
                    name: 'area_ent',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'subareaent',
                    name: 'subareaent',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'nivel_inst',
                    name: 'nivel_inst',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'btn',
                    name: 'btn',
                    orderable: true,
                    searchable: true
                }
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
@endsection
