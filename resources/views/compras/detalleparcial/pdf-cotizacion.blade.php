<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cotizacion</title>
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
            <td align="center">
                <b>INFORME DE COTIZACIÓN Y VERIFICACIÓN DE<br>DOCUMENTO N.&nbsp;{{$ordencompra->numinforme}}</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="10%">
                            <b>A:</b>
                        </td>
                        <td>
                            {{$responsables->nombrerespcontrat}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <b>{{$responsables->cargorespcontrat}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <b>VIA:</b>
                        </td>
                        <td>
                            {{$responsables->nombrerespadminist}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <b>{{$responsables->cargorespadminist}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <b>DE:</b>
                        </td>
                        <td>
                            {{$responsables->nombrerespcompr}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <b>{{$responsables->cargorespcompr}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <b>FECHA:</b>
                        </td>
                        <td>
                            {{ucfirst($fechaorden)}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <b>REF.:</b>
                        </td>
                        <td>
                            REMITE INFORME SOBRE LA COMPRA {{$ordencompra->nombrecompra}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                De mi mayor consideracion:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                A tiempo de saludarlo cordialmente, a traves del presente informe de cotización y verificación de documento, tengo a bien informar lo siguiente:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                <b>1.- REQUERIMIENTO DE ADQUISICIÓN DE MATERIALES DE ESCRITORIO PARA EL HOSPITAL FRAY QUEBRACHO Y ÁREA ADMINISTRATIVA EL PROGRAMA COVID - 19</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                La dirección de Administración de Bienes y Servicios del G.A.R.G.CH., ha sido derivado el requerimiento de ADQUISICIÓN DE MATERIALES DE ESCRITORIO PARA EL HOSPITAL FRAY QUEBRACHO Y ÁREA ADMINISTRATIVA EL PROGRAMA COVID - 19 para la unidad de UNIDAD PROGRAMA COVID - 19; que son solicitados de acuerdo al siguiente detalle:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%" class="table-border" cellpadding="2">
                    <tr class="table-border">
                        <td align="center" class="table-border"><b>N°</b></td>
                        <td align="center" class="table-border"><b>PRODUCTO</b></td>
                        <td align="center" class="table-border"><b>ESPECIFICACIONES TÉCNICAS</b></td>
                        <td align="center" class="table-border"><b>UNIDAD</b></td>
                        <td align="center" class="table-border"><b>CANT.</b></td>
                    </tr>
                    @php
                        $num = 1;
                    @endphp
                    @if (count($prodserv) > 0)
                        @foreach ($prodserv as $datos)
                            <tr class="table-border">
                                <td align="left" class="table-border">{{$num++}}</td>
                                <td align="left" class="table-border">{{$datos->nombreprodserv}}</td>
                                <td align="left" class="table-border">{{$datos->detalleprodserv}}</td>
                                <td align="center" class="table-border">{{$datos->nombreumedida}}</td>
                                <td align="right" class="table-border">{{$datos->cantidad}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                <b>2.- PRECIO REFERENCIAL</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%" class="table-border" cellpadding="2">
                    <tr class="table-border">
                        <td align="center" class="table-border" colspan="2"><b>DESCRIPCION</b></td>
                    </tr>
                    <tr class="table-border">
                        <td align="center" class="table-border" colspan="2">{{$ordencompra->nombrecompra}}</td>
                    </tr>
                    <tr class="table-border">
                        <td align="center" class="table-border">
                            PRECIO REFERENCIAL BS. 
                        </td>
                        <td align="center" class="table-border">
                            {{$valor_total}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                <b>3.- COTIZACIÓN Y VERIFICACIÓN DEL DOCUMENTO</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                Mediante invitación efectuada y aceptación del proponente según verificación correspondiente indicamos que el mismo cumple con las especificaciones técnicas solicitadas por la unidad, para tal efecto se adjunta los datos correspondientes a la cotización(Proforma):
            </td>
        </tr>
        <tr>
            <td> &nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%" class="table-border" cellpadding="2">
                    <tr class="table-border">
                        <td align="center" class="table-border"><b>N</b></td>
                        <td align="center" class="table-border"><b>EMPRESA / CASA COMERCIAL / PROVEEDOR</b></td>
                        <td align="center" class="table-border"><b>MONTO BS.</b></td>
                        <td align="center" class="table-border"><b>N° PROFORMA</b></td>
                    </tr>
                    <tr class="table-border">
                        <td align="center" class="table-border">1</td>
                        <td align="center" class="table-border">{{$ordencompra->representante}}</td>
                        <td align="center" class="table-border">{{$valor_total}}</td>
                        <td align="center" class="table-border">{{$ordencompra->hojaruta}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                Dentro de la presente cotización obtenida, se pudo constatar que la (proforma) Ofertada por "{{$ordencompra->representante}}" en el proceso {{$ordencompra->nombrecompra}}. Con un importe de Bs. {{$valor_total2}} se ajusta a las especificaciones técnicas de la unidad solicitante.
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                <b>4.- CONCLUSION Y RECOMENDACIÓN</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                Dentro del presente proceso por compra menor de bienes, consistente en "{{$ordencompra->nombrecompra}}", habiéndose recabado la información en base a las especificaciones técnicas y efectuando la verificación correspondiente, se recomienda al Responsable del Proceso de Contratación - RPA, proceder con la adjudicación correspondiente.
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
            <td align="center">
                Responsbale de Compras Menores
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