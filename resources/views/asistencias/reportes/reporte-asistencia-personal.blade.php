@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="javascript:void(0);" onclick="goBack();" class="color-icon-1" aria-label="Ir a gestionar-c">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>

            </span>
            <b> Reporte de Registro de Asistencia Personal </b>
        </div>
        <div class="col-md-4 text-right">

            <a href="{{ route('excelRegistroReporte', ['empleadoId' => $empleado_id, 'fechaInicio' => $fechaInicio, 'fechaFinal' => $fechaFinal]) }}" target="blank_">
                <button class="btn btn-sm btn-success font-verdana " type="button">
                    &nbsp; <i class="fa-solid fa-file-excel"></i> &nbsp;Exportar Excel
                </button>
            </a>
            <a href="{{ route('asistenciaPdf', ['empleadoId' => $empleado_id, 'fechaInicio' => $fechaInicio, 'fechaFinal' => $fechaFinal]) }}" target="blank_">
                <button class="btn btn-sm btn-danger font-verdana " type="button">
                    &nbsp;<i class="fa-solid fa-file-pdf"></i> &nbsp;Exportar PDF
                </button>
            </a>
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('reportes.create')}}">
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
    <div class="col-md-12">

        <table class="font-verdana">
            <tr>
                <td><b>Nombres y Apellidos :</b></td>
                <td>{{$empleadoDatos->nombres}} {{$empleadoDatos->ap_pat}} {{$empleadoDatos->ap_mat}}</td>
            </tr>
            <tr>
                <td><b>Desde:</b></td>
                <td>{{ $fechaInicio }}</td>
            </tr>
            <tr>
                <td><b>Hasta:</b></td>
                <td>{{ $fechaFinal }}</td>
            </tr>
        </table>
    </div>


    <div class="row font-verdana">

        <input type="hidden" id="data1" name="fecha_final" value="{{$empleado_id}}" class="form-control" required>
        <input type="hidden" id="data2" name="fecha_inicio" value="{{ $fechaInicio }}" class="form-control" required>
        <input type="hidden" id="data3" name="fecha_final" value="{{ $fechaFinal }}" class="form-control" required>

        <div class="col-md-12">
            <table class="table-bordered yajra-datatable hoverTable" id="retrasos-table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Nombres Apellidos</th>
                        <th>Horario</th>
                        <th> Entrada<br> Mañana</th>
                        <th> Salida<br> Mañana</th>
                        <th> Entrada <br>Tarde</th>
                        <th> Salida <br>Tarde</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Minutos <br> Retraso</th>

                    </tr>
                </thead>

            </table>
        </div>
    </div>

</div>



@section('scripts')
<script>
    function goBack() {
        history.back(); // Utiliza la función history.back() para retroceder sin recargar la página
    }
</script>
<script>
    $(document).ready(function() {
        $('#retrasos-table').DataTable({
            processing: false,
            serverSide: false,
            lengthChange: true,
            searching: false,
            ordering: false,
            paging: false,
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
            ajax: {
                url: "{{route('asistenciapersonalreportes.getReporte') }}",
                type: "GET", // Change the request type to GET
                data: function(d) {
                    // Append parameters to the URL
                    // Append parameters to the URL
                    d.empleado = $('#data1').val();
                    d.fecha_inicio = $('#data2').val();
                    d.fecha_final = $('#data3').val();
                }
            },
            columns: [{
                    data: 'fecha',
                    name: 'fecha',
                    class: 'text-justify p-1 font-verdana-sm'
                },
                {
                    data: 'nom_ap',
                    name: 'nom_ap',
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
                    data: 'estado',
                    name: 'estado',
                    class: 'text-center p-1 font-verdana-sm'
                },
                {
                    data: 'observ',
                    name: 'observ',
                    class: 'text-center p-1 font-verdana-sm'
                },
                {
                    data: 'minutos_retraso',
                    name: 'minutos_retraso',
                    class: 'text-justify p-1 font-verdana-sm'
                },
            ],
        });

    });
</script>
@endsection
@endsection