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

    <div class="page-header" align="center">
        <img src="{{ asset('logos/header.jpg') }}" width="900px" height="70px" />
    </div>

    <h3>
        Reporte Personal de Retrasos
    </h3>
    <table border="1" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
            <tr>
                <td width="34%" valign="top">
                    <p>
                        Reporte de Retrasos Personales:
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
    <table border="1" cellspacing="0" cellpadding="0" width="100%">
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
                        Unidad: {{ $empleadoDatos->empleadosareas->nombrearea }}
                    </p>
                </td>
                <td width="50%" valign="top">
                </td>
            </tr>
        </tbody>
    </table>
    <h3>
        Retrasos de Personal
    </h3>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
            <tr>
                <td width="29%" valign="top">
                <p align="center">
                        Nombres y Apellidos
                    </p>
                </td>
                <td width="28%" valign="top">
                <p align="center">
                        Minutos de Retraso
                    </p>
                </td>
                <td width="42%" valign="top">
                <p align="center">
                        Descuento Según Haber Básico
                    </p>
                </td>
            </tr>
            <tr>
                @foreach ($data['data'] as $empleado)
                <td width="28%" valign="top">
                <p align="center">
                    {{ $empleado['empleado'] }}
                </td>
                <td width="29%" valign="top">
                <p align="center">
                    {{ $empleado['total_retrasos'] }}
                </td>

                <td width="42%" valign="top">
                <p align="center">
                    {{ $empleado['observaciones'] }}

                </td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <h3>
        Detalles de Retrasos
    </h3>
    <div align="center">
        <table border="1" cellspacing="0" cellpadding="0" width="100%">
            <tbody>
                <tr>
                    <td width="10%" valign="top">
                        <p align="center">
                            Fecha
                        </p>
                    </td>
                    <td width="10%" valign="top">
                        <p align="center">
                            Horario
                        </p>
                    </td>
                    <td width="15%" valign="top">
                        <p align="center">
                            Entrada<br>
                            Mañana
                        </p>
                       
                    </td>
                    <td width="15%" valign="top">
                        <p align="center">
                            Salida<br>
                            Mañana
                        </p>
                      
                    </td>
                    <td width="15%" valign="top">
                        <p align="center">
                            Entrada<br>
                            Tarde
                        </p>
                       
                    </td>
                    <td width="15%" valign="top">
                        <p align="center">
                            Salida<br>
                            Tarde
                        </p>
                         
                    </td>
                    <td width="15%" valign="top">
                        <p align="center">
                            Minutos<br>
                            Retraso
                        </p>
                     
                    </td>
                </tr>
                @foreach ($retrasos as $registro)
                <tr>

                    <td width="10%" valign="top">
                    <p align="center">
                        {{ $registro->fecha}}
                    </td>
                    <td width="10%" valign="top">
                    <p align="center">
                        @if($registro->horario->tipo == 0)
                        {{ $registro->horario->Nombre }}<br>
                        {{ $registro->horario->hora_inicio }}<br>
                        {{ $registro->horario->hora_final }}
                        @elseif($registro->horario->tipo == 1)
                        {{ $registro->horario->Nombre }}<br>
                        {{ $registro->horario->hora_inicio }}
                        {{ $registro->horario->hora_salida }}<br>
                        {{ $registro->horario->hora_entrada }}
                        {{ $registro->horario->hora_final }}
                        @endif

                    </td>
                    <td width="15%" valign="top">
                    <p align="center">
                        {{
                            $registro->registro_inicio
                        }}
                    </td>
                    <td width="15%" valign="top">
                    <p align="center">
                        {{$registro->registro_salida}}
                    </td>
                    <td width="15%" valign="top">
                    <p align="center">
                        {{$registro->registro_entrada}}
                    </td>
                    <td width="15%" valign="top">
                    <p align="center">
                        {{$registro->registro_final}}
                    </td>
                    <td width="15%" valign="top">
                    <p align="center">
                        {{$registro->minutos_retraso}}
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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