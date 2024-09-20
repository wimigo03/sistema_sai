<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte Recepcion Ventanilla</title>
<style>
    html {
        margin: 30px 50px 50px 55px;
        font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        background-color: #ffffff;
        }

        .border-bottom {
            border-bottom: 1px solid #000000;
            border-collapse: collapse;
        }

        .border-top {
            border-top: 1px solid #000000;
            border-collapse: collapse;
        }

        .border-right {
            border-right: 1px solid #000000;
            border-collapse: collapse;
        }

        .table-titulo,
        .table-titulo th,
        .table-titulo td {
            border-collapse: collapse;
            width: 100%;
            padding: 1px;
        }

        .table-encabezado {
            border: 1px solid #000000;
            border-collapse: collapse;
            width: 100%;
        }

        .table-encabezado th,
        .table-encabezado td {
            border-collapse: collapse;
            padding: 4px;
            font-size: 9px;
        }

        .table-contenido {
            /* border: 1px solid #000000; */
            border-collapse: collapse;
            width: 100%;
            font-size: 9px;
        }

        .table-contenido th,
        .table-contenido td {
            border-collapse: collapse;
            padding: 3px;
            font-size: 9px;
            vertical-align: top;
        }

        .table-contenido tr:nth-child(even){background-color: #f2f2f2;}

        .table-contenido tr:hover {background-color: #ddd;}

        .logo-gran-chaco{
            width: 160px;
            height:auto;
            border-radius: 10%;
            overflow: hidden;
            opacity: 0.3;
        }

        .logo-nueva-historia{
            width: 100px;
            height:auto;
            border-radius: 10%;
            overflow: hidden;
            opacity: 0.3;
        }
</style>
<body>
    <table class="table-titulo">
        <tr>
            <td width="30%">
                <img src="{{ public_path('logos/gobiernoregional.jpg') }}" class="logo-gran-chaco" alt="#"/>
            </td>
            <td width="40%" align="center" style="font-size: 14px; vertical-align: bottom;">
                <b><u>RECEPCION VENTANILLA</u></b>
            </td>
            <td width="30%" align="right">
                <img src="{{ public_path('logos/mapa.png') }}" class="logo-nueva-historia" alt="#"/>
            </td>
        </tr>
    </table>
    <br>
    {{-- <table class="table-encabezado">
    </table>
    <br> --}}
    <table class="table-contenido">
        <thead class="border-bottom">
            <tr>
                <td align="left" style="width:3%; word-wrap: break-word;"><b>NRO<b></td>
                <td align="left" style="width:24%; word-wrap: break-word;"><b>NOMBRE COMPLETO<b></td>
                <td align="left" style="width:27%; word-wrap: break-word;"><b>UNIDAD<b></td>
                <td align="left" style="width:27%; word-wrap: break-word;"><b>ASUNTO<b></td>
                <td align="center" style="width:10%; word-wrap: break-word;"><b>FECHA<b></td>
                <td align="center" style="width:10%; word-wrap: break-word;"><b>CODIGO<b></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($recepciones as $datos)
                <tr>
                    <td align="left">{{ $cont++ }}</td>
                    <td align="left">{{ $datos->remitente_completo }}</td>
                    <td align="left">{{ $datos->unidad_remitente }}</td>
                    <td align="left">{{ $datos->asunto }}</td>
                    <td align="center">{{ Carbon\Carbon::parse($datos->fecha_recepcion)->format('d/m/Y') }}</td>
                    <td align="center">{{ $datos->n_oficio }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $pdf->text(40, 765, "{{ date('d/m/Y H:i') }} | {{ strtoupper($username) }}", "sans-serif", 6);
            $pdf->text(555, 765, "$PAGE_NUM de $PAGE_COUNT", "sans-serif", 6);
        ');
    }
</script>
