@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Lista de descuentos por Retraso Haber Básico</b>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('descuentos.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="Crear Nuevo Horario">
                <button class="btn btn-sm btn-primary font-verdana" type="button">
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>

    <div class="row font-verdana">
        <div class="col-md-12 center">
            <table id="descuentos-table" class="table-bordered yajra-datatable hoverTable table display responsive font-verdana" style="width:100%; margin: 0 auto;">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Tiempo Mínimo de Retraso</th>
                        <th>Días Descuento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
            <div class="row font-verdana-bg">
                <div class="col-md-12">
                    <hr class="hrr">
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        $('#descuentos-table').DataTable({
            serverSide: true,
            processing: true,
            language: {
                info: "<span class='font-verdana'>Mostrando _START_ al _END_ de _TOTAL_</span>",
                search: '',
                searchPlaceholder: "Buscar",
                paginate: {
                    next: "<span class='font-verdana'><b>Siguiente</b></span>",
                    previous: "<span class='font-verdana'><b>Anterior</b></span>",
                },
                lengthMenu: "<span class='font-verdana'>Mostrar </span>" +
                    "<select class='form form-control-sm'>" +
                    "<option value='15'>15</option>" +
                    "<option value='50'>50</option>" +
                    "<option value='100'>100</option>" +
                    "<option value='-1'>Todos</option>" +
                    "</select> <span class='font-verdana'>Registros </span>",
                loadingRecords: "<span class='font-verdana'>...Cargando...</span>",
                processing: "<span class='font-verdana'>...Procesando...</span>",
                emptyTable: "<span class='font-verdana'>No hay datos</span>",
                zeroRecords: "<span class='font-verdana'>No hay resultados para mostrar</span>",
                infoEmpty: "<span class='font-verdana'>Ningun registro encontrado</span>",
                infoFiltered: "<span class='font-verdana'>(filtrados de un total de _MAX_ registros)</span>"
            },
            ajax: "{{ route('descuentos.index') }}",
            columns: [{
                    className: 'text-center p-1 ',
                    data: 'id',
                    name: 'id',

                },
                {

                    data: 'descripcion',
                    name: 'descripcion',
                    className: 'text-center p-1 ',

                },
                {

                    data: 'tiempo',
                    name: 'tiempo',
                    className: 'text-center p-1 ',
                },
                {

                    data: 'cantidad',
                    name: 'cantidad',
                    className: 'text-center p-1 ',
                },
                {

                    className: 'text-center p-1 ',
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                targets: [0], // El índice de la columna que quieres ocultar (en este caso, la columna 'id')
                visible: false,
            }]

        });
        $('#descuentos-table').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
    });
</script>
@endsection
@endsection