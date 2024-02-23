<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Puedes agregar estilos específicos para el PDF aquí -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            /* Tamaño de la fuente para toda la tabla */
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 3px;
            /* Ajustar el relleno de celda si es necesario */
            margin-top: 0;
            margin-bottom: 0;
        }

        h3 {
            font-size: 16px;
            /* Tamaño de la fuente para los encabezados */
        }

        p {
            font-size: 12px;
            /* Tamaño de la fuente para los párrafos */
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <!-- Contenido de tu vista -->

    <div class="page-header" style="text-align: center;">
    <h3>- GOBIERNO AUTÓNOMO REGIONAL DEL GRAN CHACO - </h3>
</div>

    <h3>
        Reporte de Registros de Asistencias Personal
    </h3>
    <table border="1" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 0; margin-bottom: 0;">

        <tbody>
            <tr>
                <td width="34%" valign="top">
                    <p>
                        Reporte de Registros de Asistencia:
                    </p>
                </td>
                <td width="33%" valign="top">
                    <p>
                        Desde: {{$fechaInicio}}
                    </p>
                </td>
                <td width="33%" valign="top">
                    <p>
                        Hasta: {{$fechaFinal}}

                    </p>
                </td>

            </tr>
            <tr>
                <td width="34%" valign="top">
                    <p>
                        Nombre y Apellidos: {{$empleadoDatos->nombres}}
                        {{$empleadoDatos->ap_pat}}
                        {{$empleadoDatos->ap_mat}}
                    </p>

                </td>
                <td width="33%" valign="top">
                    <p>
                        CI: {{$empleadoDatos->ci}}
                    </p>

                </td>
                <td width="33%" valign="top">
                    <p>
                        Unidad/Area: {{ $empleadoDatos->empleadosareas->nombrearea }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>


    <h3>
        Asistencias Registradas
    </h3>

    <table border="1" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 0; margin-bottom: 0;">
        <tbody>
            <tr>
                <td width="6%" nowrap="">
                    <p align="center">
                        <strong>Fecha</strong>
                    </p>
                </td>
                <td width="13%" nowrap="">
                    <p align="center">
                        <strong>Nombres Apellidos</strong>
                    </p>
                </td>
                <td width="12%" nowrap="">
                    <p align="center">
                        <strong>Horario</strong>
                    </p>
                </td>
                <td width="8%">
                    <p align="center">
                        <strong>Entrada <br />
                            Mañana</strong>
                    </p>
                </td>
                <td width="8%">
                    <p align="center">
                        <strong>Salida <br />
                            Mañana</strong>
                    </p>
                </td>
                <td width="8%">
                    <p align="center">
                        <strong>Entrada <br />
                            Tarde</strong>
                    </p>
                </td>
                <td width="7%">
                    <p align="center">
                        <strong>Salida <br />
                            Tarde</strong>
                    </p>
                </td>
                <td width="7%" nowrap="">
                    <p align="center">
                        <strong>Estado</strong>
                    </p>
                </td>
                <td width="8%" nowrap="">
                    <p align="center">
                        <strong>Observaciones</strong>
                    </p>
                </td>
                <td width="9%">
                    <p align="center">
                        <strong>Minutos <br />
                            Retraso</strong>
                    </p>
                </td>
            </tr>
            @foreach ($registros as $asistencia)

            <?php
            $fechaAsistencia = $asistencia->fecha;
            $estiloFondo = '';

            if (\Carbon\Carbon::parse($fechaAsistencia)->isWeekend()) {
                $estiloFondo = 'background-color: lightgrey;';
            }
            ?>

            <tr style="<?php echo $estiloFondo; ?>">
                <td width="6%" nowrap="">
                    <p align="center">
                        {{ $asistencia->fecha }}
                    </p>
                </td>
                <td width="13%" nowrap="">
                    <p>
                        {!! nl2br(e($asistencia->nombre_empleado)) !!}<br>
                        {{ $asistencia->ap}}

                    </p>
                </td>

                <td width="12%">
                    <p align="center">
                        @if($asistencia->ht ==1)

               {{ $asistencia->hn }}<br>
                    {{ $asistencia->hi }} - {{ $asistencia->hf }} <br>
                    {{ $asistencia->he }} - {{ $asistencia->hs }}
                
                @else

                

                    {{ $asistencia->hn }}<br>
                    {{ $asistencia->hi }} - {{ $asistencia->hf }}
                
                @endif
                </p>
                </td>


                <td width="8%" nowrap="">
                    <p align="center">
                        {{ $asistencia->registro_inicio }}
                    </p>
                </td>
                <td width="8%" nowrap="">
                    <p align="center">
                        {{ $asistencia->registro_salida }}
                    </p>
                </td>
                <td width="8%" nowrap="">
                    <p align="center">
                        {{ $asistencia->registro_entrada }}
                    </p>
                </td>
                <td width="7%" nowrap="">
                    <p align="center">
                        {{ $asistencia->registro_final }}

                    </p>
                </td>

                <td width="8%" nowrap="">
                    <p align="center">
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

                    </p>
                </td>


                <td width="12%">
                    <p align="center">
                        {!! nl2br(e($asistencia->ovb)) !!}
                    </p>
                </td>


                <td width="9%" nowrap="">
                    <p align="center">
                        {{ $asistencia->minutos_retraso }}
                    </p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Usuario
        {{ $nombreCompleto }} -
        {{ Auth()->user()->name }}
        {{ date("d-m-Y H:i") }}
    </h5>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Serif", "normal");
                $pdf->text(50, 770, "{{ date("d-m-Y H:i") }} / Usuario : {{ Auth()->user()->name }} Nombre Completo-{{ $nombreCompleto}}", $font, 7);
                $pdf->text(530, 765, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 7);
            ');
        }
    </script>
</body>

</html>