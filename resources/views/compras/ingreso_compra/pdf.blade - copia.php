<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso de Materiales</title>
<style>
    html {
        margin: 30px 50px 50px 55px;
        font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        background-color: #ffffff;
        }

        .border-contorno {
            border-bottom: 1px solid #000000;
            border-top: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            border-collapse: collapse;
        }

        .border-bottom {
            border-bottom: 1px solid #000000;
            border-collapse: collapse;
        }

        .border-top {
            border-top: 1px solid #000000;
            border-collapse: collapse;
        }

        .border-left {
            border-left: 1px solid #000000;
            border-collapse: collapse;
        }

        .border-right {
            border-right: 1px solid #000000;
            border-collapse: collapse;
        }

        .table-titulo{
            width: 100%;
        }
        .table-titulo th,
        .table-titulo td {
            /* border: 1px solid #000000; */
            border-collapse: collapse;
            padding: 1px;
            font-size: 14px;
            /* vertical-align: bottom; */
        }

        .table-titulo-datos {
            border: 1px solid rgba(0, 0, 0, 0.5);
            width: 100%;
        }

        .table-titulo-datos th,
        .table-titulo-datos td {
            border: 1px solid #000000;
            border-collapse: collapse;
            padding: 2px;
            font-size: 9px;
        }

        .table-encabezado {
            border: 1px solid #000000;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 1px;
        }

        .table-encabezado th,
        .table-encabezado td {
            border-collapse: collapse;
            padding: 5px;
            font-size: 9px;
        }

        .table-pie {
            /* border: 1px solid #000000; */
            border-collapse: collapse;
            width: 100%;
        }

        .table-pie th,
        .table-pie td {
            border-collapse: collapse;
            padding: 0px;
            font-size: 9px;
        }

        .table-contenido {
            /* border: 1px solid #000000; */
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
            <td width="23%">
                <img src="{{ public_path('logos/gobiernoregional.jpg') }}" class="logo-gran-chaco" alt="#"/>
            </td>
            <td width="54%" align="center">
                <b>
                    NOTA DE INGRESO
                    <br>
                    <span style="font-size: 11px;"><u>{{ $ingreso_compra->status }}</u></span>
                </b>
            </td>
            <td width="23%" align="right">
                {{-- <img src="{{ public_path('logos/mapa.png') }}" class="logo-nueva-historia" alt="#"/> --}}
                <table class="table-titulo-datos">
                    <tr>
                        <td>
                            <b>N° PREVENTIVO</b>
                        </td>
                        <td align="right">
                            {{ $ingreso_compra->orden_compra->nro_preventivo }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>CODIGO</b>
                        </td>
                        <td align="right">
                            {{ $ingreso_compra->codigo }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>FECHA</b>
                        </td>
                        <td align="right">
                            {{ \Carbon\Carbon::parse($ingreso_compra->fecha_ingreso)->format('d/m/Y') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>
    <table class="table-encabezado">
        <tr>
            <td style="width:40%; word-wrap: break-word;">
                @if ($ingreso_compra->user != null)
                    <b>INGRESADO POR: </b>{{ $ingreso_compra->user != null ? strtoupper($ingreso_compra->user->name) : '' }}
                @endif
            </td>
            <td style="width:35%; word-wrap: break-word;">
                <b>ALMACEN: </b>{{ $ingreso_compra->almacen->nombre }}
            </td>
            <td style="width:25%; word-wrap: break-word;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>PROVEEDOR: </b>{{ $ingreso_compra->proveedor->representante }}
            </td>
            <td>
                <b>N° ORDEN DE COMPRA: </b>{{ $ingreso_compra->orden_compra->codigo }}
            </td>
        </tr>
        <tr>
            <td>
                <b>NIT: </b>{{ $ingreso_compra->proveedor->nit }}
            </td>
            <td>
                <b>TELEFONO: </b>{{ $ingreso_compra->proveedor->telefono }}
            </td>
            <td>
                <b>N° DE SOLICITUD: </b>{{ $ingreso_compra->solicitud_compra->codigo }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>AREA SOLICITANTE: </b>{{ $ingreso_compra->area->nombrearea }}
            </td>
        </tr>
    </table>
    <br>
    <table class="table-contenido">
        <tbody>
            @foreach($ingreso_compra_detalles as $datos)
                <tr class="border-bottom">
                    <td align="left" colspan="5"><b>{{ $datos->codigo . ' - '. $datos->nombre }}</b></td>
                    <td align="right"><b>SUB TOTAL</b></td>
                    <td align="right"><b>{{ $datos->total_partidas }}</b></td>
                </tr>
                <thead class="border-bottom">
                    <tr>
                        <td align="left" style="width:3%; word-wrap: break-word;"><b>N<b></td>
                        <td align="center" style="width:10%; word-wrap: break-word;"><b>CODIGO<b></td>
                        <td align="left" style="width:47%; word-wrap: break-word;"><b>DETALLE<b></td>
                        <td align="center" style="width:10%; word-wrap: break-word;"><b>UNIDAD<b></td>
                        <td align="right" style="width:10%; word-wrap: break-word;"><b>INGRESO<b></td>
                        <td align="right" style="width:10%; word-wrap: break-word;"><b>P.U./NETO<b></td>
                        <td align="right" style="width:10%; word-wrap: break-word;"><b>TOTAL<b></td>
                    </tr>
                </thead>
                @foreach($detalles_items->where('partida_presupuestaria_id', $datos->partida_presupuestaria_id) as $datos_detalle)
                    <tr>
                        <td align="center">{{ $cont++ }}</td>
                        <td align="center">{{ $datos_detalle->item->codigo }}</td>
                        <td>{{ $datos_detalle->item->detalle }}</td>
                        <td align="center">{{ $datos_detalle->item->unidad_medida->alias }}</td>
                        <td align="right">{{ number_format($datos_detalle->cantidad,2,'.',',') }}</td>
                        <td align="right">{{ number_format($datos_detalle->orden_compra_detalle->precio,2,'.',',') }}</td>
                        <td align="right">{{ number_format($datos_detalle->cantidad * $datos_detalle->orden_compra_detalle->precio,2,'.',',') }}</td>
                    </tr>
                @endforeach
                <br>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" align="right" class="border-top">
                    <b>TOTAL</b>
                </td>
                <td align="right" class="border-top">
                    <b>{{ number_format($total,2,'.',',') }}</b>
                </td>
            </tr>
        </tfoot>
    </table>
    <table class="table-pie">
        <tr>
            <td>
                <b>SON: </b>{{ $total_en_letras }}
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
        </tr>
        @if ($ingreso_compra->estado != '1')
            <tr>
                <td>
                    <p><b>OBSERVACIONES:</b> {{ strtoupper($ingreso_compra->obs) }}</p>
                </td>
            </tr>
        @endif
    </table>
    <br>
    <br>
    <br>
    <br>
    <table class="table-pie">
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
                <b>RECIBI CONFORME</b>
                <br>
                {{-- {{ $mantenimiento->funcionario->full_name }} --}}
            </td>
            <td align="center" style="vertical-align: top;">
                <b>ENTREGUE CONFORME</b>
            </td>
        </tr>
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
