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
        Reporte de Retrasos por Unidad
    </h3>
    <table border="1" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
            <tr>
                <td width="34%" valign="top">
                    <p>
                        Reporte de Retrasos por Unidad:
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
                        Nombre de Unidad: {{$areasDatos->nombrearea}}
                   
                    </p>
                 
                </td>
                <td width="50%" valign="top">
                    <p>
                        Nivel:  
                    </p>
  
                </td>
            </tr>
          
        </tbody>
    </table>
    <h3>
        Lista de Personal 
    </h3>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
            <tr>
                <td width="29%" valign="top">
                <p align="center left">
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
                <p align="center left">
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