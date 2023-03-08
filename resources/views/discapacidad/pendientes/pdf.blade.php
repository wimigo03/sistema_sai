<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Entregas pendientes</title>
    <style>
        html{
            margin: 94.49px 94.49px 94.49px 94.49px;
            /*font-size: 1em;*/
            font-size: 11px;
            /*font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";*/
            font-family: Serif;
            /*line-height: 2.0;*/
            /*background-color: #ffffff;*/
        }
        table,tr,td{
            border-collapse: collapse;
        }
        .table-border{
            border-collapse: collapse;
            border: 0.5px solid
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td align="center"><b>ENTREGAS PENDIENTES</b></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table width="100%" class="table-border">
        <thead>
            <tr>
                <td class="table-border" align="left"><b>NUM.</b></td>
                <td class="table-border" align="left"><b>COD.</b></td>
                <td class="table-border" align="left"><b>NRO. CI</b></td>
                <td class="table-border" align="left"><b>NOMBRES</b></td>
                <td class="table-border" align="left"><b>APELLIDOS</b></td>
                <td class="table-border" align="left"><b>EDAD</b></td>
                <td class="table-border" align="left"><b>BARRIO</b></td>
                <td class="table-border" align="left"><b>CARNET DISC.</b></td>
                <td class="table-border" align="left"><b>VENCIMIENTO</b></td>
                <td class="table-border" align="left"><b>TUTOR</b></td>
            </tr>
        </thead>
        @php
            $num = 1;
        @endphp
        <tbody>
            @if (count($entrega_temp) > 0)
                @foreach ($entrega_temp as $datos)
                    <tr>
                        <td class="table-border" align="left">{{$num++}}</td>
                        <td class="table-border" align="left">{{$datos->id_ent}}</td>
                        <td class="table-border" align="left">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->carnet}}</td>
                        <td class="table-border" align="left">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->nombres}}</td>
                        <td class="table-border" align="left">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->apellidos}}</td>
                        <td class="table-border" align="left">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->edad}}</td>
                        <td class="table-border" align="left">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->barrio_com}}</td>
                        <td class="table-border" align="left">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->carnet_discap}}</td>
                        <td class="table-border" align="left">{{$datos->afiliado == null ? 'S/N':\Carbon\Carbon::parse($datos->afiliado->f_vencimiento)->format('d/m/Y')}}</td>
                        <td class="table-border" align="left">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->nombre_tutor}}</td>
                    </tr> 
                @endforeach
            @endif
        </tbody>
    </table>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Serif", "normal");
                $pdf->text(50, 570, "{{ date('d-m-Y H:i') }} / {{ Auth()->user()->name }}", $font, 7); 
                $pdf->text(700, 565, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 7); 
            ');
        }
    </script>
</body>
</html>