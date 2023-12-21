<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Puedes agregar estilos específicos para el PDF aquí -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <!-- Contenido de tu vista -->

    
    <h3>
        Reporte de Registros de Asistencias
    </h3>
    <table border="1" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
            <tr>
                <td width="34%" valign="top">
                    <p>
                        Reporte Personal de Registros de Asistencia:
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
        </tbody>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
            <tr>
                <td width="50%" valign="top">
                    <p>
                        Nombre y Apellidos: {{$empleadoDatos->nombres}}
                        {{$empleadoDatos->ap_pat}}
                        {{$empleadoDatos->ap_mat}}
                    </p>

                </td>
                <td width="50%" valign="top">
                    <p>
                        CI: {{$empleadoDatos->ci}}
                    </p>

                </td>
            </tr>
            <tr>
                <td width="50%" valign="top">
                    <p>
                        Unidad/Area: {{ $empleadoDatos->empleadosareas->nombrearea }}
                    </p>
                </td>
                <td width="50%" valign="top">
                </td>
            </tr>
        </tbody>
    </table>

    <h3>
        Asistencias Registradas
    </h3>

    <table border="1" cellspacing="0" cellpadding="0" width="100%">
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
            @foreach ($registros as $row)

            <tr>
                <td width="6%" nowrap="">
                    <p align="center">
                        {{ $row->fecha}}
                    </p>
                </td>
                <td width="13%" nowrap="">
                    <p>
                        {{ $row->empleado->nombres }} {{ $row->empleado->ap_pat ?? '-' }} {{ $row->empleado->ap_mat ?? '-' }}
                    </p>
                </td>

                <td width="12%">
                    <p align="center">
                        @php

                        $nombre = $row->horario->Nombre ?: '';
                        $final = $row->horario->hora_final ? : '-';
                        $inicio = $row->horario->hora_inicio ?  : '-';
                        $html = '';

                        if ($row->horario->tipo == 1) {
                        $salida = $row->horario->hora_salida ?: '-';
                        $entrada = $row->horario->hora_entrada ?  : '';
                        $html = '<span>' . $nombre . '</span><br><span>' . $inicio . '-' . $salida . '</span><br><span>' . $entrada . '-' . $final . '</span>';
                        } elseif ($row->horario->tipo == 0) {
                        $html = '<span>' . $nombre . '</span><br><span>' . $inicio . '</span><br><span>' . $final . '</span>';
                        }
                        @endphp
                        {!! $html !!}
                    </p>
                </td>
                <td width="8%" nowrap="">
                    <p align="center">
                        @if ( $row->registro_inicio)
                      {{  $row->registro_inicio}}
                        @else
                        -
                        @endif
                    </p>
                </td>
                <td width="8%" nowrap="">
                    <p align="center">
                        @if ( $row->registro_salida)
                       {{ $row->registro_salida}}
                        @else
                        -
                        @endif
                    </p>
                </td>
                <td width="8%" nowrap="">
                    <p align="center">
                        @if ( $row->registro_entrada)
                       {{ $row->registro_entrada}}
                        @else
                        -
                        @endif
                    </p>
                </td>
                <td width="7%" nowrap="">
                    <p align="center">

                        @if ($row->registro_final)
                       {{ $row->registro_final}}
                        @else
                        -
                        @endif
                    </p>
                </td>
                <td width="7%" nowrap="">
                    <p align="center">
                        @if ($row->estado == 0)
                        Sin Registro
                        @elseif ($row->estado == 1)
                        Registrado
                        @elseif ($row->estado == 2)
                        Pendiente
                        @else
                        -
                        @endif
                    </p>
                </td>
                <td width="8%" nowrap="">
                    <p align="center">

                        @if ($row->observ)
                        <span>{!! nl2br(e($row->observ)) !!}</span>
                        @else
                        -
                        @endif
                    </p>
                </td>
                <td width="9%" nowrap="">
                    <p align="center">
                        @if ($row->minutos_retraso)
                       {{ $row->minutos_retraso}}
                        @else
                        -
                        @endif
                    </p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Serif", "normal");
                $pdf->text(50, 770, "{{ date("d-m-Y H:i") }} / {{ Auth()->user()->name }}", $font, 7);
                $pdf->text(530, 765, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 7);
            ');
        }
    </script>
</body>

</html>