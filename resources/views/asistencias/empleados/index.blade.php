@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Lista de Asistencias de Empleados</b>
        </div>
        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('horarios.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
        <div class="col-md-12">
            <!-- Dentro de tu vista -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
            @endif
            <hr class="hrr">
        </div>
    </div>

    <div class="row font-verdana">
        <div class="col-md-12 table-responsive center">
            <table class="table-bordered yajra-datatable hoverTable table display responsive font-verdana" id="empleados-table">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Horarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


@section('scripts')
<script>
    $(document).ready(function() {
        $('#empleados-table').DataTable({

            responsive: true,
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
            ajax: "{{ route('empleadoasistencias.index') }}",

            columns: [{
                    data: 'id',
                    name: 'id',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'nombres',
                    name: 'nombres',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'apellidos',
                    name: 'apellidos',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'horario',
                    name: 'horario',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    class: 'text-justify p-1 font-verdana-sm'
                }
            ]

        });
        $('#empleados-table').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
    });
</script>
@endsection
@endsection