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

        <table id="retrasos-table" class="table-compact yajra-datatable hoverTable table display responsive font-verdana" style="width:100%">
            <thead>
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
            <tbody>
                @foreach($registros as $asistencia)
                <?php
                $fechaAsistencia = $asistencia->fecha;
                $estiloFondo = '';

                if (\Carbon\Carbon::parse($fechaAsistencia)->isWeekend()) {
                    $estiloFondo = 'background-color: lightgrey;';
                }
                ?>

                <tr style="<?php echo $estiloFondo; ?>">

                    <td>{{ $asistencia->fecha }}</td>
                    <td>{{ $asistencia->nombre_empleado }}</td>
                    @if($asistencia->ht ==1)

                    <td>{{ $asistencia->hn }}<br>
                        {{ $asistencia->hi }} - {{ $asistencia->hf }} <br>
                        {{ $asistencia->he }} - {{ $asistencia->hs }}
                    </td>
                    @else

                    <td>

                        {{ $asistencia->hn }}<br>
                        {{ $asistencia->hi }} - {{ $asistencia->hf }}
                    </td>
                    @endif
                    <td>{{ $asistencia->registro_inicio }}</td>
                    <td>{{ $asistencia->registro_salida }}</td>

                    <td>{{ $asistencia->registro_entrada }}</td>
                    <td>{{ $asistencia->registro_final}}</td>

                    <td>{{ $asistencia->minutos_retraso }}</td>

                    <td>
                        @if ($asistencia->est == 1)
                        Registrado
                        @elseif ($asistencia->est == 2)
                        Falta
                        @elseif ($asistencia->est == 0)
                        Falta
                        @elseif ($asistencia->est == 3)
                        Marcado
                        @elseif(
                        \Carbon\Carbon::parse($asistencia->fecha)->isWeekend())

                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $asistencia->ovb }}</td>
                    <!-- Agrega más celdas según tus necesidades -->
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

<div class="col-md-12">
    <!-- Dentro de tu vista -->
    <hr class="hrr">
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
            "lengthMenu": [
                [-1],
                ["All"]
            ], // Permite ver todos los registros
            "lengthChange": false, // Desactiva el cambio de longitud
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            }
        });
    });
</script>
@endsection
@endsection