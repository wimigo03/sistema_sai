@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b> Permisos Personales </b>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('permisospersonales.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="Crear Nuevo Reporte">
                <button class="btn btn-sm btn-primary font-verdana" type="button">
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
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
        <div class="col-md-12">
            <table class="table" id="empleados-table">
                <thead>
                    <tr>
                        <th>Empleado</th>
                        <th>Permiso</th>
                        <th>Hora de Salida</th>
                        <th>Hora de Retorno</th>
                        <th>Fecha de Solicitud</th>
                        <th>Horas Utilizadas</th>
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
            serverSide: true,
            ajax: '{{ route("empleados.get") }}',
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
            columns: [{
                    data: 'empleado.nombre',
                    name: 'empleado.nombre'
                },
                {
                    data: 'permiso.permiso',
                    name: 'permiso.permiso'
                },
                {
                    data: 'hora_salida',
                    name: 'hora_salida'
                },
                {
                    data: 'hora_retorno',
                    name: 'hora_retorno'
                },
                {
                    data: 'fecha_solicitud',
                    name: 'fecha_solicitud'
                },
                {
                    data: 'horas_utilizadas',
                    name: 'horas_utilizadas'
                }
            ]
        });
    });
</script>
@endsection
@endsection