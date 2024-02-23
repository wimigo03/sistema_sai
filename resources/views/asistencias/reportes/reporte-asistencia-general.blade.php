@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <br>
    <div class="row font-verdana-sm">
        <div class="col-md-8 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            <b> REPORTE GENERAL DE ASISTENCIAS</b>
        </div>
        <div class="col-md-4 text-right titulo">
            <div class="btn-group">
                <b> Fecha: </b>



            </div>

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>

    <div class="row font-verdana">
        <div class="col-md-12">
            @foreach ($registrosPorEmpleado as $empleado_id => $registrosEmpleado)
            <h2>Registros para el empleado {{ $empleado_id }}</h2>

            <table id="tablaAsistencias" class="table-bordered yajra-datatable hoverTable font-verdana-sm" style="width:100%">

                <tr>
                    <th>Fecha</th>
                    <th>Nombres Apellidos</th>
                    <th>Horario</th>
                    <th>Entrada<br>Mañana</th>
                    <th>Salida<br>Mañana</th>
                    <th>Entrada<br>Tarde</th>
                    <th>Salida<br>Tarde</th>
                    <th>Minutos<br>Retraso</th>
                    <th>Estado</th>
                    <th>Observaciones</th>
                    <!-- Agrega más columnas según tus necesidades -->
                </tr>
                </thead>
                <tbody>
                    @foreach($registrosEmpleado as $asistencia)
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

            @endforeach

        </div>
    </div>

</div>
<div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
    <h5 class="col-md-4 text-right titulo font-verdana-sm">Usuario
        {{ $nombreCompleto }} -
        {{ Auth()->user()->name }}
        {{ date("d-m-Y H:i") }}
    </h5>
</div>
<div class="col-md-12">
    <hr class="hrr">
</div>

@endsection