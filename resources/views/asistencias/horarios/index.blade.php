@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <div class="row font-verdana-bg">
        <div class="col-md-4 titulo mt-4">
            <b>Lista de Horarios de Trabajo</b>
        </div>
       
        @can('horario_access')
        <div class="col-md-8 text-right">
            <a href="{{ route('empleadoasistencias.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="Ver Empleados">
                <button class="btn btn-sm btn-info font-verdana" type="button" aria-label="Ver Empleados ">
                    &nbsp;<i class="fa-solid fa-users-line">Empleados</i>&nbsp;
                </button>
            </a>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

            <a href="{{ route('horarios.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="Crear Nuevo Horario">
                <button class="btn btn-sm btn-success font-verdana" type="button" aria-label="Agregar Nuevo Horario">
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        @endcan
        <div class="col-md-12">
            @if(Session::has('pendiente'))
            <hr>
            <div class="alert alert-danger font-verdana-bg">
                {{ Session::get('pendiente') }}
            </div>
            @endif

            @if(Session::has('success'))
            <hr>
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            @if(Session::has('error'))
            <hr>
            <div class="alert alert-danger font-verdana-bg">
                {{ Session::get('error') }}
            </div>
            @endif
            <hr class="hrr">
        </div>
    </div>
    <div class="row font-verdana">
        <div class="col-md-12 table-responsive center">
            <table id="horarios-table" class="table-bordered yajra-datatable hoverTable font-verdana-sm" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Hora de Entrada</th>
                        <th>Hora de Salida</th>
                        <th>Asignados</th>
                        <th>Tiempo de Excepcion</th>
                        <th>Estado</th>
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
        $('#horarios-table').DataTable({
            serverSide: true,
            processing: true,
            ordering: true,  
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
            ajax: "{{ route('horarios.index') }}",

            columns: [{
                    className: 'text-center p-1 font-verdana',
                    data: 'Nombre',
                    name: 'Nombre'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'entrada',
                    name: 'entrada'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'salida',
                    name: 'salida'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'asignados',
                    name: 'asignados'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'excepcion',
                    name: 'excepcion'
                },

                {
                    className: 'text-center p-1 font-verdana',
                    data: 'estado',
                    name: 'estado'
                },
                {
                    className: 'text-center p-1 font-verdana',
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $('#horarios-table').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
    });
</script>
<script>
    function submitForm(link) {
        var form = link.parentNode; // Obtener el formulario padre del enlace
        form.submit(); // Enviar el formulario
    }
</script>

<!-- Agrega este código en tu vista Blade -->

@endsection
@endsection