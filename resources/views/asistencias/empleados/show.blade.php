@extends('layouts.admin')

@section('content')
<div class="container ">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Registro de Asistencias</b>
        </div>

        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('empleadoasistencias.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>


            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        <div class="col-md-12">
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
                        <th>Horario</th>
                        <th>Registro Entrada</th>
                        <th>Registro Salida</th>
                        <th>Minutos de Retraso</th>
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
            processing: true,
            serverSide: true,
            ajax: "{{ route('empleadoasistencias.show', $empleado->idemp) }}",
            orderFixed: [0, 'desc'],
            rowGroup: {
                dataSrc: 'fecha'
            },
            columns: [{
                    data: 'fecha',
                    name: 'fecha',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'horario',
                    name: 'horario',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'hora_entrada',
                    name: 'hora_entrada',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'hora_salida',
                    name: 'hora_salida',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'minutos_retraso',
                    name: 'minutos_retraso',
                    class: 'text-justify p-1 font-verdana-sm'
                },

            ]
        });
    });
</script>
@endsection
@endsection