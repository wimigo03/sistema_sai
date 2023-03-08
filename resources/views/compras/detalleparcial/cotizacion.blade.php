@extends('layouts.admin')
@section('content')
@if(Session::has('message'))
<div class="alert alert-success">
    <em> {!! session('message') !!}</em>
</div>
@endif

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3>Cotizacion </h3>

    </div>
</div>
<script type="text/javascript">
function imprSelec(muestra) {
    var ficha = document.getElementById(muestra);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
}

function colorChanger(el) {
    el.style.backgroundColor = '#696969';

}

function colorChanger2(el) {
    el.style.backgroundColor = 'transparent';
}
</script>
<a href="{{ url('/compras/detalle') }}" class="btn blue darken-4 text-black "><i class="fa fa-plus-square"></i> Volver
    atras</a>
<button data-id="5" onclick="javascript:imprSelec('muestra')">Imprimir</button>

<div id="muestra" align="center">

    <table style="width: 4.6e+2pt;border: none;margin-left:2.75pt;border-collapse:collapse;">
        <tbody>
            <tr>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 39pt;vertical-align: bottom;"><br></td>
                <td colspan="9" style="width:366.45pt;padding:0cm 3.5pt 0cm 3.5pt;height:39.0pt;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <strong><span style="font-size:21px;color:black;">INFORME DE COTIZACI&Oacute;N Y
                                VERIFICACI&Oacute;N DE DOCUMENTO N&deg;{{$ordencompra->numinforme}}</span></strong>
                    </p>
                </td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 39pt;vertical-align: bottom;"><br></td>
                <td style="height:39.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="12" rowspan="2"
                    style="width: 461.45pt;padding: 0cm 3.5pt;height: 22.5pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">A:</span></strong><span style="color:black;">&nbsp; &nbsp;
                            &nbsp; &nbsp; &nbsp;{{$responsables->nombrerespcontrat}}<br> <strong>&nbsp; &nbsp; &nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp;{{$responsables->cargorespcontrat}}&nbsp;</strong></span>
                    </p>
                </td>
                <td style="height:22.5pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:13.45pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="9" style="width: 366.45pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">VIA: &nbsp; &nbsp;&nbsp;</span></strong><span
                            style="color:black;">&nbsp;{{$responsables->nombrerespadminist}}</span>
                    </p>
                </td>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;"><br></td>
                <td style="height:18.75pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="11" style="width: 419.45pt;padding: 0cm 3.5pt;height: 16.5pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp;{{$responsables->cargorespadminist}}</span></strong>
                    </p>
                </td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 16.5pt;vertical-align: bottom;"><br></td>
                <td style="height:16.5pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="12" rowspan="2"
                    style="width: 461.45pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">DE:</span></strong><span style="color:black;">&nbsp; &nbsp;
                            &nbsp; &nbsp;{{$responsables->nombrerespcompr}}<br> <strong>&nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp; &nbsp; &nbsp; {{$responsables->cargorespcompr}}&nbsp;</strong></span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:14.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 71pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 69pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 90pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 41.45pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br>
                </td>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="height:11.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">Fecha:</span></strong>
                    </p>
                </td>
                <td colspan="4" style="width: 230pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">{{$fechaorden}}</span></strong>
                    </p>
                </td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 41.45pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="12" style="width: 461.45pt;padding: 0cm 3.5pt;height: 37.5pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <strong><span style="color:black;">REF.: REMITE INFORME SOBRE LA COMPRA
                                &nbsp;{{$ordencompra->nombrecompra}}</span></strong>
                    </p>
                </td>
                <td style="height:37.5pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="6" style="width: 283pt;padding: 0cm 3.5pt;height: 21pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">De mi mayor consideraci&oacute;n.</span>
                    </p>
                </td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 21pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 41.45pt;padding: 0cm 3.5pt;height: 21pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 21pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 21pt;vertical-align: bottom;"><br></td>
                <td style="height:21.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 5.25pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 71pt;padding: 0cm 3.5pt;height: 5.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 69pt;padding: 0cm 3.5pt;height: 5.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 90pt;padding: 0cm 3.5pt;height: 5.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 5.25pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 41.45pt;padding: 0cm 3.5pt;height: 5.25pt;vertical-align: bottom;"><br>
                </td>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 5.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 5.25pt;vertical-align: bottom;"><br></td>
                <td style="height:5.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="12" rowspan="2" style="width:461.45pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">A tiempo de saludarlo cordialmente, a traves &nbsp;del presente
                            &nbsp;informe de cotizaci&oacute;n y verificaci&oacute;n de documento, tengo a bien informar
                            lo siguiente:</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:21.75pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 71pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 69pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 90pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 41.45pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br>
                </td>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td style="height:6.75pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="12" style="width: 461.45pt;padding: 0cm 3.5pt;height: 31.5pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">1.- REQUERIMIENTO DE ADQUISICI&Oacute;N DE MATERIALES DE
                                ESCRITORIO PARA EL HOSPITAL FRAY QUEBRACHO Y &Aacute;REA ADMINISTRATIVA EL PROGRAMA
                                COVID - 19</span></strong>
                    </p>
                </td>
                <td style="height:31.5pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="5" style="width: 193pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 90pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 41.45pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br>
                </td>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 6.75pt;vertical-align: bottom;"><br></td>
                <td style="height:6.75pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="12" rowspan="3"
                    style="width: 461.45pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">La Direcci&oacute;n de Administraci&oacute;n de Bienes y Servicios
                            del G.A.R.G.CH, ha sido derivado el requerimiento de ADQUISICI&Oacute;N DE MATERIALES DE
                            ESCRITORIO PARA EL HOSPITAL FRAY QUEBRACHO Y &Aacute;REA ADMINISTRATIVA EL PROGRAMA COVID -
                            19 para la unidad de UNIDAD PROGRAMA COVID - 19; que son solicitados de acuerdo al siguiente
                            detalle :</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>


            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:32.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 71pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 69pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 90pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 41.45pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>



            <table style="margin: 0 auto;" width="80%" border="1" style="font-size:10px;color:black">
                <tr>

                    <th style="background:#A6A6A6;">N°</th>
                    <th style="background:#A6A6A6;">NOMBRE DEL PRODUCTO</th>
                    <th style="background:#A6A6A6;">ESPECIFICACIONES TECNICAS</th>
                    <th style="background:#A6A6A6;">UNIDAD</th>
                    <th style="background:#A6A6A6;">CANTIDAD</th>



                </tr>
                @forelse ($prodserv as $key =>$prod)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{ $prod -> nombreprodserv}}</td>
                    <td>{{ $prod -> detalleprodserv}}</td>
                    <td>{{ $prod -> nombreumedida}}</td>
                    <td>{{ $prod -> cantidad}}</td>



                </tr>
                @empty

                @endforelse

            </table>

            <tr>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>



            </tr>
            <tr>
                <td colspan="6" style="width: 283pt;padding: 0cm 3.5pt;height: 25.5pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">2.- PRECIO REFERENCIAL</span></strong>
                    </p>
                </td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 25.5pt;vertical-align: bottom;"><br></td>


            </tr>

            <table style="border: none;border-collapse: collapse;width:363pt;margin: 0 auto;">
                <tbody>
                    <tr>
                        <td colspan="6"
                            style="color:black;font-size:13px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#A6A6A6;height:20.25pt;width:363pt;">
                            DESCRIPCION</td>
                    </tr>
                    <tr>
                        <td colspan="6"
                            style="color:black;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:general;vertical-align:middle;border:.5pt solid windowtext;text-align:center;height:32.25pt;width:363pt;">
                            &nbsp;{{$ordencompra->nombrecompra}}&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4"
                            style="color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:center;vertical-align:bottom;border:.5pt solid windowtext;height:15.0pt;width:272pt;">
                            PRECIO REFERENCIAL BS.-</td>
                        <td colspan="2"
                            style="color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:center;vertical-align:bottom;border:.5pt solid windowtext;border-left:none;width:91pt;">
                            {{$valor_total}} &nbsp;</td>
                    </tr>
                </tbody>
            </table>






            <tr>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>


            </tr>
            <tr>
                <td colspan="6" style="width: 283pt;padding: 0cm 3.5pt;height: 27pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">3.- COTIZACI&Oacute;N Y VERIFICACI&Oacute;N DE
                                DOCUMENTO</span></strong>
                    </p>
                </td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 27pt;vertical-align: bottom;"><br></td>

            </tr>

            <tr>
                <td colspan="12" rowspan="2" style="width:461.45pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">Mediante &nbsp;invitaci&oacute;n efectuada &nbsp; y &nbsp; &nbsp;
                            aceptaci&oacute;n &nbsp;del proponente seg&uacute;n verificaci&oacute;n correspondiente
                            indicamos que el mismo cumple con las especificaciones t&eacute;cnicas solicitadas por la
                            unidad, para tal efecto se adjunta los datos correspondientes a la cotizaci&oacute;n
                            (Proforma):</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>

            <table style="border: none;border-collapse: collapse;width:428pt;margin: 0 auto;">
                <tbody>
                    <tr>
                        <td
                            style="color:black;font-size:15px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:center;vertical-align:bottom;border:.5pt solid windowtext;background:#A6A6A6;height:15.0pt;width:71pt;">
                            N&ordm;</td>
                        <td colspan="4"
                            style="color:black;font-size:15px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:center;vertical-align:bottom;border:.5pt solid windowtext;background:#A6A6A6;border-left:none;width:239pt;">
                            EMPRESA/CASA COMERCIAL/PROVEEDOR</td>
                        <td
                            style="color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:general;vertical-align:bottom;border:.5pt solid windowtext;background:#A6A6A6;border-left:none;width:53pt;">
                            MONTO BS</td>
                        <td
                            style="color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:general;vertical-align:bottom;border:.5pt solid windowtext;background:#BFBFBF;border-left:none;width:65pt;">
                            N&ordm; PROFOMA</td>
                    </tr>
                    <tr>
                        <td
                            style="color:black;font-size:15px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:center;vertical-align:bottom;border:.5pt solid windowtext;height:15.0pt;border-top:none;">
                            1</td>
                        <td colspan="4"
                            style="color:black;font-size:15px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:general;vertical-align:bottom;border:.5pt solid windowtext;text-align:center;border-left:none;">
                            &nbsp;{{$ordencompra->representante}}&nbsp;</td>
                        <td
                            style="color:black;font-size:11px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:general;vertical-align:bottom;border:none;border:.5pt solid windowtext;border-top:none;border-left:none;">
                            &nbsp; &nbsp; &nbsp; {{$valor_total}} &nbsp;&nbsp;</td>
                        <td
                            style="color:black;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri, sans-serif;text-align:center;vertical-align:bottom;border:.5pt solid windowtext;border-top:none;border-left:none;">
                            {{$ordencompra->hojaruta}}</td>
                    </tr>
                </tbody>
            </table>

            <tr>
                <td colspan="2" style="width: 53pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 71pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>


            </tr>
            <tr>
                <td colspan="12" rowspan="5"
                    style="width: 461.45pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">Dentro de la presente cotizaci&oacute;n obtenida, se pudo constatar
                            que la &nbsp; &nbsp; (proforma) Ofertada por
                            &nbsp;&ldquo;{{$ordencompra->representante}}&ldquo;
                            en el proceso {{$ordencompra->nombrecompra}} &nbsp;Con un importe &nbsp;de Bs.
                             &nbsp;- {{$valor_total2}}
                            se ajusta
                            a &nbsp;las especificaciones t&eacute;cnicas de la unidad solicitante.</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>


            <tr>
                <td colspan="6" style="width: 283pt;padding: 0cm 3.5pt;height: 17.25pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">4.- CONCLUSI&Oacute;N Y RECOMENDACI&Oacute;N</span></strong>
                    </p>
                </td>
                <td style="width: 42pt;padding: 0cm 3.5pt;height: 17.25pt;vertical-align: bottom;"><br></td>
                <td colspan="2" style="width: 41.45pt;padding: 0cm 3.5pt;height: 17.25pt;vertical-align: bottom;"><br>
                </td>

            </tr>

            <tr>
                <td colspan="12" rowspan="5"
                    style="width: 461.45pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">Dentro del presente proceso por compra menor de bienes, consistente
                            en &ldquo;{{$ordencompra->nombrecompra}}&rdquo;, habi&eacute;ndose recabado la
                            informaci&oacute;n &nbsp;en base a las especificaciones t&eacute;cnicas y &nbsp;efectuando
                            la verificaci&oacute;n correspondiente, se recomienda al Responsable del Proceso de
                            Contrataci&oacute;n - RPA, proceder con la adjudicaci&oacute;n correspondiente.</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:13.45pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:33.0pt;border:none;"><br></td>
            </tr>


            <tr>
                <td colspan="12" style="width: 461.45pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <span style="color:black;">Responsable de Compras Menores</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection