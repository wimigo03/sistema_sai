@extends('layouts.admin')
@section('content')
@if(Session::has('message'))
<div class="alert alert-success">
    <em> {!! session('message') !!}</em>
</div>
@endif

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3>Invitacion </h3>

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

    <table border='1'>
        <tbody>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td colspan="4" style="width: 241.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:right;'>
                        <span style="color:black;">Yacuiba, &nbsp;{{$fechaInvitacion}} &nbsp;</span></p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td colspan="4" style="width: 241.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:right;'>
                        <span style="color:black;">CITE:&nbsp;{{$ordencompra->codciteinvitacion}}</span></p>
                </td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">Se&ntilde;or:</span></p>
                </td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 120.7pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><u><span style="color:black;">Potencial Proponente</span></u></strong></p>
                </td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td rowspan="2" style="width: 61.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <br></p>
                </td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">Presente. -</span></p>
                </td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 10.5pt;vertical-align: bottom;"><br></td>
                <td style="height:10.5pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="8" rowspan="3"
                    style="width: 483.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">REF.: INVITACI&Oacute;N PARA EL PRESENTE PROCESO DE
                                CONTRATACI&Oacute;N MENOR<br> {{$ordencompra->nombrecompra}}</span></strong></p>
                </td>

                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="height:29.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 12pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 12pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 12pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 12pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 12pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 12pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 12pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 12pt;vertical-align: bottom;"><br></td>
                <td style="height:12.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 120.7pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">De mi consideraci&oacute;n:</span></p>
                </td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="8" rowspan="4"
                    style="width: 483.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">El Gobierno Aut&oacute;nomo &nbsp;Regional del Gran Chaco, a
                            trav&eacute;s del Responsable del Proceso de Contrataci&oacute;n, &nbsp; &nbsp; designado
                            mediante &nbsp;Resoluci&oacute;n Administrativa N&ordm; 25/2021 de fecha 8 de Julio de 2021,
                            en el marco de sus atribuciones, tiene a bien invitarle a participar del &nbsp;Proceso de
                            Contrataci&oacute;n de referencia, para tal efecto adjunto especificaciones t&eacute;cnicas
                            presentados por la unidad solicitante, bajo la Modalidad de Contrataci&oacute;n
                            Menor.</span></p>
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
                <td style="height:30.75pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="height:11.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="8" rowspan="2"
                    style="width: 483.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
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
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 11.25pt;vertical-align: bottom;"><br></td>
                <td style="height:11.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="8" rowspan="5" style="width:483.35pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">En caso de aceptaci&oacute;n, deber&aacute; presentar la
                            documentaci&oacute;n requerida &nbsp; &nbsp; de acuerdo a las Especificaciones
                            T&eacute;cnicas, hasta el d&iacute;a &nbsp;{{$fechaAceptacion}} &nbsp; del presente
                            A&ntilde;o a horas &nbsp;{{$ordencompra->horapresentacion}} &nbsp; en Oficinas de la
                            &nbsp;Secretaria Regional de Econom&iacute;a y Finanzas Publicas del G.A.R.G.CH, Adjuntado
                            la siguiente documentaci&oacute;n para su verificaci&oacute;n y si corresponde posterior
                            formalizaci&oacute;n de la contrataci&oacute;n:</span></p>
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
                <td style="height:13.45pt;border:none;"><br></td>
            </tr>
            <tr>
                <td colspan="4" style="width: 242.2pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <strong><span style="color:black;">Documentaci&oacute;n Solicitada:</span></strong></p>
                </td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 18pt;vertical-align: bottom;"><br></td>
                <td style="height:18.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 8.25pt;vertical-align: bottom;"><br></td>
                <td style="height:8.25pt;border:none;"><br></td>
            </tr>

            <table>

                @forelse ($ordendoc as $key => $value)
                <tr>
                    <td class="text-center" style="color:black">{{$key+1}}.&nbsp; </td>
                    <td style="color:black">{{$value -> nombredoc}}</td>

                </tr>
                @empty

                @endforelse
            </table>

            <tr>
                <td colspan="7" style="width: 420pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>

            <tr>
                <td colspan="6" style="width: 362.95pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="font-size:13px;color:black;">Agradeceremos la aceptaci&oacute;n.</span></p>
                </td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>

            <tr>
                <td colspan="2" style="width: 120.7pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>
                        <span style="color:black;">Atentamente,</span></p>
                </td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>

                <td style="height:15.0pt;border:none;"><br></td>
            </tr>

            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td colspan="6" rowspan="4"
                    style="width: 362.8pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;">
                    <p
                        style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'>
                        <span style="font-size:12px;color:black;">{{$responsables->nombrerespcontrat}}<br>
                            <strong>RESPONSABLE DEL PROCESO DE CONTRATACI&Oacute;N DE &nbsp; APOYO NACIONAL A &nbsp;LA
                                PRODUCCI&Oacute;N Y EMPLEO (RPA ANPE)&nbsp;</strong></span></p>
                </td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 2.25pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 2.25pt;vertical-align: bottom;"><br></td>
                <td style="height:2.25pt;border:none;"><br></td>
            </tr>
            <tr>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.35pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 61.15pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.55pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="width: 60.2pt;padding: 0cm 3.5pt;height: 15pt;vertical-align: bottom;"><br></td>
                <td style="height:15.0pt;border:none;"><br></td>
            </tr>
        </tbody>
    </table>

</div>
@endsection