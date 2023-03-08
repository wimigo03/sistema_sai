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
    <table width="100%" border="1">
        <tr>
            <td align="right">
                Yacuiba, {{$fechaInvitacion}}
            </td>
        </tr>
        <tr>
            <td align="right">
                CITE: {{$ordencompra->codciteinvitacion}}
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                Señor.-
            </td>
        </tr>
        <tr>
            <td>
                <u><b>Potencial Proponente</b></u>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
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
                <b>REF.: INVITACION PARA EL PRESENTE PROCESO DE CONTRATACION MENOR {{$ordencompra->nombrecompra}}</b>
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
                El Gobierno Autónomo Regional del Gran Chaco, a través del Responsable del Proceso de Contratación, designado mediante Resolución Administrativa Nº 25/2021 de fecha 8 de Julio de 2021, en el marco de sus atribuciones, tiene a bien invitarle a participar del Proceso de Contratación de referencia, para tal efecto adjunto especificaciones técnicas presentados por la unidad solicitante, bajo la Modalidad de Contratación Menor.
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">
                <b>{{$ordencompra->nombrecompra}}</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                En caso de aceptación, deberá presentar la documentación requerida de acuerdo a las Especificaciones Técnicas, hasta el día 22 de octubre del presente Año a horas 11:11 en Oficinas de la Secretaria Regional de Economía y Finanzas Publicas del G.A.R.G.CH, Adjuntado la siguiente documentación para su verificación y si corresponde posterior formalización de la contratación:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <b>Documentacion Solicitada:</b>
            </td>
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
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">
                Atentamente,
            </td>
        </tr>
        <tr>
            <td align="center">
                {{$responsables->nombrerespcontrat}}<br><b>RESPONSABLE DEL PROCESO DE CONTRATACION DE <br>APOYO NACIONAL A LA PRODUCCION Y EMPLEO (RPA ANPE)</b>
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