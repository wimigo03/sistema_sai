@extends('layouts.admin')
@section('content')
@if(Session::has('message'))
<div class="alert alert-success">
    <em> {!! session('message') !!}</em>
</div>
@endif

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3>Adjudicacion</h3>

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

    <table style="border: none;width:438.0pt;margin-left:2.75pt;border-collapse:collapse;">
        <tbody>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="height:18.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="7" style="width: 438pt;padding: 0cm 3.5pt;height: 24pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <strong><span style="font-size:21px;color:black;">NOTA DE ADJUDICACI&Oacute;N</span></strong>
                    </p>
                </td>
                <td style="height:24.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="7" style="width: 438pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <strong><span style="color:black;">GOBIERNO AUT&Oacute;NOMO REGIONAL DEL GRAN
                                CHACO</span></strong>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="7" style="width: 438pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <strong><span style="color:black;">{{$ordencompra->numnotaadjudicacion}}</span></strong>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="7" style="width: 438pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <strong><span style="color:black;">Yacuiba, &nbsp;{{$fechaorden}} &nbsp;</span></strong>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 18.75pt;vertical-align: bottom;"><br></td>
                <td style="height:18.75pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="7" rowspan="5" style="width: 438pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: top;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">En fecha &nbsp;{{$fechainiciosolici}} del presente A&ntilde;o,
                            mediante solicitud del {{$ordencompra->autoridadsolicitante}}, &nbsp;se solicita el inicio
                            de proceso de contrataci&oacute;n: &nbsp; {{$ordencompra->nombrecompra}}, adjuntando para el
                            efecto, las Especificaciones T&eacute;cnicas, &nbsp;precio referencial, Certificaci&oacute;n
                            Presupuestaria y formulario de solicitud de inicio numero dos&nbsp;</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:22.5pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="height:8.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="7" rowspan="4"
                    style="width: 438pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">En mi condici&oacute;n &nbsp;de Responsable del proceso de
                            Contrataci&oacute;n en Apoyo de la producci&oacute;n y empleo &ndash; RPA, Designado
                            mediante Resoluci&oacute;n Administrativa N&ordm; 25/2021 de fecha 8 de Julio de 2021 en uso
                            de mis facultades conferidas &nbsp;por &nbsp;los &nbsp; &nbsp; Arts. 52, 53 y 54 del D.S.
                            N&deg; 0181.&nbsp;</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:13.45pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">RESUELVE:</span></strong>
                    </p>
                </td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="height:8.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="7" rowspan="4"
                    style="width: 438pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">De acuerdo a la invitaci&oacute;n, aceptaci&oacute;n y
                            verificaci&oacute;n &nbsp;de informaci&oacute;n presentada por el Invitado, &nbsp;se
                            &nbsp;procede a Adjudicar al proponente: &nbsp; {{$ordencompra->representante}}, para el
                            siguiente proceso de &nbsp;contrataci&oacute;n:&nbsp;</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:13.45pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="7" rowspan="2"
                    style="width: 438pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <strong><span style="color:black;">&nbsp;{{$ordencompra->nombrecompra}}&nbsp;</span></strong>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 17.25pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">Plazo de entrega:</span></strong>
                    </p>
                </td>
                <td colspan="6" style="width:356.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:17.25pt;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <span style="font-size:11px;color:black;">{{$ordencompra->plazoentrega}} D&Iacute;AS
                            CALENDARIOS, A PARTIR DEL SIGUIENTE D&Iacute;A H&Aacute;BIL DE LA SUSCRIPCI&Oacute;N DE LA
                            ORDEN DE COMPRA</span>
                    </p>
                </td>
                <td style="height:17.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 142pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">Monto Total (Bs):</span></strong>
                    </p>
                </td>
                <td colspan="3" style="width: 180pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="font-size:12px;color:black;">{{$valor_total}}</span>
                    </p>
                </td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 12.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 12.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 12.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 12.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 12.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 12.75pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 12.75pt;vertical-align: bottom;"><br></td>
                <td style="height:12.75pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="7" rowspan="2"
                    style="width: 438pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">Debido a que la documentaci&oacute;n presentada por el proponente se
                            ajusta a las &nbsp; &nbsp; especificaciones t&eacute;cnicas requeridas por la unidad
                            solicitante.</span>
                    </p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:21.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="3" style="width: 202pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">Sin otro particular Notif&iacute;quese la Nota.</span>
                    </p>
                </td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td colspan="5" rowspan="4"
                    style="width: 300pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <span style="font-size:13px;color:black;">{{$responsables->nombrerespcontrat}}<br> <strong>RPA
                                &ndash; ANPE<br>&nbsp;GOBIERNO AUT&Oacute;NOMO REGIONAL DEL GRAN CHACO</strong></span>
                    </p>
                </td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 82pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 56pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
        </tbody>
    </table>

</div>
@endsection