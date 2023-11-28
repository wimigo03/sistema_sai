<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Orden de compra</title>
    <style>
        html{
            margin: 94.49px 94.49px 94.49px 94.49px;
            /*font-size: 1em;*/
            font-size: 12px;
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
            <td width="40%">
                <table width="100%">
                    <tr>
                        <td>
                            Gobierno Autonomo Regional del Gran Chaco
                        </td>
                    </tr>
                    <tr>
                        <td>
                            1ra Seccion - Provincia Gran Chaco
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tel/Fax: 46822039
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tarija - Bolivia
                        </td>
                    </tr>
                </table>
            </td>
            <td width="25%">
                <table width="100%">
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                </table>
            </td>
            <td width="25%" valign="top">
                <table width="100%" class="table-border">
                    <tr class="table-border">
                        <td>
                            Orden de Compra
                        </td>
                        <td align="right">
                            {{$ordencompra->nordencompra}}
                        </td>
                    </tr>
                    <tr class="table-border">
                        <td>
                            Preventivo
                        </td>
                        <td align="right">
                            {{$ordencompra->npreventivo}}
                        </td>
                    </tr>
                    <tr class="table-border">
                        <td>
                            Control interno
                        </td>
                        <td align="right">
                            {{$ordencompra->numcontrolinterno}}
                        </td>
                    </tr>
                    <tr class="table-border">
                        <td>
                            Hoja de Ruta
                        </td>
                        <td align="right">
                            {{$ordencompra->hojaruta}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Lugar y Fecha. Yacuiba, {{$fechaInvitacion}}
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td>
                UNIDAD DE COMPRAS MENORES
            </td>
        </tr>
    </table>
    <table width="100%">
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
                <b>{{--$ordencompra->nombrecompra--}}</b>
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
        {{--@php
            $num = 1;
        @endphp
        @if (count($ordendoc) > 0)
            @foreach ($ordendoc as $datos)
                <tr>
                    <td>{{$num . '.- ' . $datos->nombredoc}}</td>
                </tr>
            @endforeach    
        @endif--}}
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