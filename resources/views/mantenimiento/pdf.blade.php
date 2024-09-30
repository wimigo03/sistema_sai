<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Formulario de Mantenimiento</title>
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
            /* border: 1px solid #000000; */
            border-collapse: collapse;
            width: 100%;
        }

        .table-encabezado th,
        .table-encabezado td {
            border-collapse: collapse;
            padding: 4px;
            font-size: 10px;
        }

        .table-subencabezado {
            /* border: 1px solid #000000; */
            border-collapse: collapse;
            width: 100%;
        }

        .table-subencabezado th,
        .table-subencabezado td {
            border-collapse: collapse;
            padding: 4px;
            font-size: 11px;
        }

        .table-pie {
            /* border: 1px solid #000000; */
            border-collapse: collapse;
            width: 100%;
        }

        .table-pie th,
        .table-pie td {
            border-collapse: collapse;
            padding: 4px;
            font-size: 9px;
        }

        .table-contenido {
            border: 1px solid #000000;
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
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
            opacity: 0.9;
        }

        .logo-nueva-historia{
            width: 100px;
            height:auto;
            border-radius: 10%;
            overflow: hidden;
            opacity: 0.9;
        }
</style>
<body>
    <table class="table-titulo">
        <tr>
            <td width="30%">
                <img src="{{ public_path('logos/gobiernoregional.jpg') }}" class="logo-gran-chaco" alt="#"/>
            </td>
            <td width="40%" align="center" style="font-size: 12px; vertical-align: bottom;">
                <b>
                    FORMULARIO DE CONFORMIDAD DE REVISION Y ENTREGA DE EQUIPOS
                </b>
            </td>
            <td width="30%" align="right">
                <img src="{{ public_path('logos/mapa.png') }}" class="logo-nueva-historia" alt="#"/>
            </td>
        </tr>
    </table>
    <br>
    <table class="table-encabezado">
        <tr>
            <td>
                <b>CODIGO: </b>{{ $mantenimiento->codigo }}
            </td>
            <td>
                <b>FECHA DE RECEPCION: </b>{{ $mantenimiento->f_h_registro }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>PROCEDENCIA: </b>{{ $mantenimiento->area->nombrearea }}
            </td>
        </tr>
        <tr>
            <td>
                <b>ENCARGADO: </b>{{ $mantenimiento->funcionario->full_name }}
            </td>
            <td>
                <b>N° COM. INT.: </b>{{ $mantenimiento->nro_comunicacion_interna }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>OBSERVACIONES: </b>{{ $mantenimiento->observaciones }}
            </td>
        </tr>
    </table>
    <br>
    <table class="table-contenido">
        <thead class="border-bottom">
            <tr>
                <td align="left" style="width:2%; word-wrap: break-word;"><b>N<b></td>
                <td align="left" style="width:9%; word-wrap: break-word;"><b>CODIGO/SERIE<b></td>
                <td align="left" style="width:8%; word-wrap: break-word;"><b>CLASIFICACION<b></td>
                <td align="left" style="width:18%; word-wrap: break-word;"><b>DETALLE DE LAS FALLAS<b></td>
                <td align="left" style="width:7%; word-wrap: break-word;"><b>E/ENTRADA<b></td>
                <td align="left" style="width:7%; word-wrap: break-word;"><b>E/SALIDA<b></td>
                <td align="left" style="width:18%; word-wrap: break-word;"><b>DIAGNOSTICO<b></td>
                <td align="left" style="width:18%; word-wrap: break-word;"><b>TRABAJO REALIZADO<b></td>
                <td align="left" style="width:8%; word-wrap: break-word;"><b>ESTADO<b></td>
                <td align="left" style="width:5%; word-wrap: break-word;"><b>TECNICO<b></td>
            </tr>
        </thead>
        <tbody>
            @foreach($mantenimiento_detalles as $datos)
                <tr>
                    <td>{{ $cont++ }}</td>
                    <td>{{ $datos->codigo_serie }}</td>
                    <td>{{ $datos->clasificacion_equipo }}</td>
                    <td>{{ $datos->problema_equipo }}</td>
                    <td>{{ $datos->status_general_entrada }}</td>
                    <td>{{ $datos->status_general_salida }}</td>
                    <td>{{ $datos->diagnostico }}</td>
                    <td>{{ $datos->solucion_equipo }}</td>
                    <td>{{ $datos->status }}</td>
                    <td>{{ $datos->user_asignado != null ? strtoupper($datos->user_asignado->name) : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table-subencabezado">
        <tr>
            <td>
                <p>
                    Nota. El diagnostico final detalla el estado actual del equipo y solicita respuestos si es necesario para su posterior reparacion.
                </p>
            </td>
        </tr>
    </table>
    <table class="table-subencabezado">
        <tr>
            <td>
                <p>
                    El presente documento detalla el trabajo realizado por la Unidad de Sistemas, tras la revisión exhaustiva de los componentes del equipo descritos en el reporte de falla al ser ingresado bajo custodia de nuestra unidad. Al firmar el Funcionario acepta la conformidad del estado en el cual se esta restituyendo el equipo.
                </p>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <table class="table-subencabezado">
        <tr>
            <td align="center">
                ________________________________________
            </td>
            <td align="center">
                ________________________________________
            </td>
        </tr>
        <tr>
            <td align="center" style="vertical-align: top;">
                Recibi Conforme
            </td>
            <td align="center">
                Entregue Conforme
                <br>
                Ing. Wilson Martinez Oropeza
                <br>
                Responsable de Sistemas
            </td>
        </tr>
    </table>
</body>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $pdf->text(40, 590, "{{ date('d/m/Y H:i') }} | {{ strtoupper($username) }}", "sans-serif", 6);
            $pdf->text(738, 590, "$PAGE_NUM de $PAGE_COUNT", "sans-serif", 6);
        ');
    }
</script>
