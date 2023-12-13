@extends('layouts.admin')

@section('content')
<div class="container ">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b>Registro de Asistencias</b>
        </div>

        <div class="col-md-4 text-right">
            <div class="btn-group">
                <select id="filtro" aria-label="Seleciona los registros" class="form-control">
                    <option value="todos" {{ $filtro == 'todos' ? 'selected' : '' }}>Todos</option>
                    <option value="actual" {{ $filtro == 'actual' ? 'selected' : '' }}>Hoy</option>
                    <option value="mensual" {{ $filtro == 'mensual' ? 'selected' : '' }}>Mensual</option>
                </select>
            </div>
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>


        </div>
    

        <div class="col-md-12">
        <hr class="hrr">
            <b>Nombres y Apellidos: {{$empleado->nombres}} {{$empleado->ap_pat}} {{$empleado->ap_pat}}</b>

            <hr class="hrr">
        </div>
    </div>
    <div class="row font-verdana">
        <div class="col-md-12">

            <table class="table-bordered yajra-datatable hoverTable font-verdana-sm" style="width:100%" id="registrosTable">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Nombres Apellidos</th>
                        <th>Horario</th>
                        <th> Entrada<br> Mañana</th>
                        <th> Salida<br> Mañana</th>
                        <th> Entrada <br>Tarde</th>
                        <th> Salida <br>Tarde</th>
                        <th>Minutos <br> Retraso</th>
                        <th>Observacion </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        $('#registrosTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 5,
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
            orderFixed: [0, 'desc'],

            ajax: {
                url: "{{ route('empleadoasistencias.show', $empleado->idemp) }}",
                data: function(d) {
                    // Agregar parámetro de filtro de fecha
                    d.filtro = $('#filtro').val();
                }

            },

            columns: [{
                    data: 'fecha',
                    name: 'fecha',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'nombres',
                    name: 'nombres',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'horario',
                    name: 'horario',
                    class: 'text-center p-1 font-verdana-sm'

                },
                {
                    data: 'registro_inicio',
                    name: 'registro_inicio',
                    class: 'text-center p-1 font-verdana-sm'
                },
                {
                    data: 'registro_salida',
                    name: 'registro_salida',
                    class: 'text-center p-1 font-verdana-sm'
                },
                {
                    data: 'registro_entrada',
                    name: 'registro_entrada',
                    class: 'text-center p-1 font-verdana-sm'
                },

                {
                    data: 'registro_final',
                    name: 'registro_final',
                    class: 'text-center p-1 font-verdana-sm'
                },
                {
                    data: 'minutos_retraso',
                    name: 'minutos_retraso',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'observ',
                    name: 'observ',
                    class: 'text-justify p-1 font-verdana-sm'
                },
            ],

            buttons: [{
                extend: 'colvis',
                collectionLayout: 'fixed columns',
                collectionTitle: 'Control de Visibilidad de Columnas',
                className: 'btn btn-sm btn-info',
            }],



        });

        $('#filtro').on('change', function() {
            $('#registrosTable').DataTable().ajax.reload();

        });
    });
</script>
@endsection
@endsection