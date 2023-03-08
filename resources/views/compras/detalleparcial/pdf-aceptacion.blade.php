<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invitacion</title>
    <style>
        html{
            margin: 94.49px 94.49px 94.49px 94.49px;
            /*font-size: 1em;*/
            font-size: 14px;
            /*font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";*/
            font-family: Serif;
            /*line-height: 2.0;*/
            /*background-color: #ffffff;*/
        }
        table{
            border-collapse: collapse;
            /*border: 0.5px solid*/
        }
        td{
            border-collapse: collapse;
            /*border: 0.2px solid*/
        }
        tr{
            border-collapse: collapse;
            /*border: 0.2px solid*/
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td align="right">
                Yacuiba, {{$fechaInvitacion}}
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                Sr.
            </td>
        </tr>
        <tr>
            <td>
                {{$responsables->nombrerespcontrat}}
            </td>
        </tr>
        <tr>
            <td>
                <b>RESPONSABLE DEL PROCESO DE CONTRATACIÓN (RPA) - G.A.R.G.CH.</b>
            </td>
        </tr>
        <tr>
            <td>
                Presente.-
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <b>REF.: ACEPTACIÓN A LA INVITACIÓN REALIZADA EN EL PROCESO DE CONTRATACIÓN MENOR COMPRA {{$ordencompra->nombrecompra}}</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                De mi mayor consideracion:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Mediante la presente manifiesto mi aceptación a invitación recibida en fecha 25 de abril del presente Año, para el Proceso de Contratación {{$ordencompra->nombrecompra}} , adjunto a la misma la documentación solicitada:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        @php
            $num = 1;
        @endphp
        @if (count($ordendoc) > 0)
            @foreach ($ordendoc as $datos)
                <tr>
                    <td>{{$num . '.- ' . $datos->nombredoc}}</td>
                </tr>
            @endforeach    
        @endif
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                Esperando una respuesta favorable me despido con la mayor consideración.
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">
                {{$ordencompra->representante}}
            </td>
        </tr>
        <tr>
            <td align="center">
                <b>C.I.N&deg; {{$ordencompra->cedula}}</b>
            </td>
        </tr>
    </table>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Serif", "normal");
                $pdf->text(50, 770, "{{ date('d-m-Y H:i') }} / {{ Auth()->user()->name }}", $font, 7); 
                $pdf->text(530, 765, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 7); 
            ');
        }
    </script>
</body>
</html>