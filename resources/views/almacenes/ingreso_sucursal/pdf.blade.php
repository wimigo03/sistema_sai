<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pdf</title>
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
        border-collapse: collapse;
        padding: 1px;;
        vertical-align: bottom;
    }

    .table-titulo-datos {
        width: 100%;
    }

    .table-titulo-datos th,
    .table-titulo-datos td {
        border-collapse: collapse;
    }

    .table-encabezado {
        /*border: 1px solid #000000;*/
        width: 100%;
    }

    .table-encabezado th,
    .table-encabezado td {
        border: 1px solid #000000;
        border-collapse: collapse;
        padding: 3px;
        font-size: 10px;
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
        font-size: 10px;
    }

    .table-contenido {
        border-collapse: collapse;
        width: 100%;
    }

    .table-contenido th,
    .table-contenido td {
        border-collapse: collapse;
        padding: 3px;
        font-size: 10px;
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
            <td width="30%" align="right">
                <table class="table-titulo-datos">
                    <tr>
                        <td>
                            <b><span style="font-size: 22px;">N° {{ $ingreso_almacen->codigo }}</span></b>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="40%" align="center">
                &nbsp;
            </td>
            <td width="30%" align="right">
                <img src="{{ public_path('/storage/images/gobierno_regional.jpg') }}" class="logo-gran-chaco" alt="#"/>
            </td>
        </tr>
    </table>
    <table class="table-titulo">
        <tr>
            <td width="100%" align="center">
                <b>
                    <span style="font-size: 18px;">
                        @if ($ingreso_almacen->codigo != 0)
                            NOTA DE INGRESO
                        @else
                            INVENTARIO INICIAL
                        @endif
                    </span>
                    <br>
                    <span style="font-size: 12px;"><u>{{ $ingreso_almacen == '2' ? '' : $ingreso_almacen->status }}</u></span>
                </b>
            </td>
        </tr>
    </table>
    <table class="table-encabezado">
        <tr>
            <td style="width:30%; word-wrap: break-word; border: 0px;">
                @if($ingreso_almacen->n_preventivo != null)
                    <b>N° PREVENTIVO:</b> <span style="font-size: 11px;">{{ $ingreso_almacen->n_preventivo }}</span>
                @endif
            </td>
            <td style="width:40%; word-wrap: break-word; border: 0px;" align="center">
                <b>SUCURSAL:</b> <span style="font-size: 11px;">{{ $ingreso_almacen->almacen->nombre }}</span>
            </td>
            <td style="width:30%; word-wrap: break-word; border: 0px;" align="right">
                <b>FECHA:</b> <span style="font-size: 11px;">{{ \Carbon\Carbon::parse($ingreso_almacen->fecha_ingreso)->format('d-m-Y') }}</span>
            </td>
        </tr>
    </table>
    @if($ingreso_almacen->codigo != 0)
        <table class="table-encabezado">
            <tr>
                <td style="width:25%; word-wrap: break-word;">
                    <b>NIT:</b> <span style="font-size: 11px;">{{ $ingreso_almacen->proveedor != null ? $ingreso_almacen->proveedor->nit : '' }}</span>
                </td>
                <td style="width:75%; word-wrap: break-word;">
                    <b>PROVEEDOR:</b> <span style="font-size: 11px;">{{ $ingreso_almacen->proveedor != null ? strtoupper($ingreso_almacen->proveedor->nombre) : '' }}</span>
                </td>
            </tr>
        </table>
    @endif
    @if($ingreso_almacen->codigo != 0)
        <table class="table-encabezado">
            <tr>
                <td style="width:20%; word-wrap: break-word;">
                    <b>N° O.C.:</b> <span style="font-size: 11px;">{{ $ingreso_almacen->n_orden_compra }}</span>
                </td>
                <td style="width:20%; word-wrap: break-word;">
                    <b>N° SOLICITUD:</b> <span style="font-size: 11px;">{{ $ingreso_almacen->n_solicitud }}</span>
                </td>
                <td style="width:60%; word-wrap: break-word;">
                    <b>SOLICITANTE:</b> <span style="font-size: 11px;">{{ strtoupper($ingreso_almacen->area->nombrearea) }}</span>
                </td>
            </tr>
        </table>
    @endif
    <br>
    <table class="table-contenido">
        @php
            $formato = fn($n) => number_format($n, 2, ',', '.');
        @endphp
        @foreach ($ingreso_almacen_detalles as $categoriaNombre => $partidas)
            @php
                $categoriaTotal = $partidas->flatten()->sum(fn($d) => $d->cantidad * $d->precio_unitario);
            @endphp
            <tr class="border-bottom">
                <td colspan="4">
                    <b>PROYECTO:</b> {{ $partidas->first()->first()->categoria_programatica->codigo ?? '' }} - {{ $categoriaNombre }}
                </td>
                <td colspan="2" align="right">
                    <b>TOTAL:</b> {{ $formato($categoriaTotal) }}
                </td>
            </tr>
            @foreach ($partidas as $partidaNombre => $detalles)
                @php
                    $partidaTotal = $detalles->sum(fn($d) => $d->cantidad * $d->precio_unitario);
                @endphp
                <tr class="border-bottom">
                    <td colspan="4">
                        <b>PARTIDA PRESUPUESTARIA:</b> {{ $detalles->first()->first()->partida_presupuestaria->numeracion ?? '' }} - {{ $partidaNombre }}
                    </td>
                    <td colspan="2" align="right">
                        <b>SUB TOTAL:</b> {{ $formato($partidaTotal) }}
                    </td>
                </tr>
                <tr>
                    <td align="center" style="width:15%; word-wrap: break-word;"><b>CODIGO<b></td>
                    <td style="width:42%; word-wrap: break-word;"><b>DETALLE<b></td>
                    <td align="center" style="width:10%; word-wrap: break-word;"><b>UNIDAD<b></td>
                    <td align="right" style="width:10%; word-wrap: break-word;"><b>INGRESO<b></td>
                    <td align="right" style="width:10%; word-wrap: break-word;"><b>P.U./NETO<b></td>
                    <td align="right" style="width:10%; word-wrap: break-word;"><b>TOTAL<b></td>
                </tr>
                @foreach ($detalles as $detalle)
                    <tr>
                        <td align="center" style="width:10%; word-wrap: break-word;">{{ $detalle->producto->codigo ?? 'N/A' }}</td>
                        <td style="width:10%; word-wrap: break-word;">{{ $detalle->producto->nombre ?? 'N/A' }}</td>
                        <td align="center" style="width:10%; word-wrap: break-word;">{{ $detalle->producto->unidad_medida->alias ?? 'N/A' }}</td>
                        <td align="right" style="width:10%; word-wrap: break-word;">{{ $detalle->cantidad }}</td>
                        <td align="right" style="width:10%; word-wrap: break-word;">{{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td align="right" style="width:10%; word-wrap: break-word;">{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
        @endforeach
        <tr class="border-bottom">
            <td colspan="6" align="right"><b>TOTAL: {{ $formato($totalGeneral) }}</b></td>
        </tr>
    </table>
    <br>
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
        <tr>
            <td>
                <p style="text-align: justify;"><b>GLOSA:</b> {{ strtoupper($ingreso_almacen->obs) }}</p>
            </td>
        </tr>
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
