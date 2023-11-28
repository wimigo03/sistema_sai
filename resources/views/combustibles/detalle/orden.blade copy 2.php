@extends('layouts.admin')
@section('content')
@if(Session::has('message'))
<div class="alert alert-success">
    <em> {!! session('message') !!}</em>
</div>
@endif

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3>Detalle de Compra </h3>

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

<button data-id="5" onclick="javascript:imprSelec('muestra')">Imprimir</button>
<a href="{{ url('/compras/detalle') }}" class="btn blue darken-4 text-black "><i class="fa fa-plus-square"></i> Volver atras</a>
<div id="muestra" align="center">
<table >
    <tbody>
        <tr>
            <td colspan="3" style="width: 288pt;padding: 0cm 3.5pt;height: 30.75pt;vertical-align: bottom;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:16px;color:black;">&nbsp; &nbsp; <u>Gobierno Aut&oacute;nomo Regional Del Gran Chaco</u></span></strong></p>
            </td>
            <td style="width:56.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:30.75pt;"><br></td>
            <td rowspan="2" style="width:69.0pt;border:none;border-right:  solid windowtext 1.0pt;padding:  0cm 3.5pt 0cm 3.5pt;height:30.75pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:13px;color:black;">&nbsp;</span></strong></p>
            </td>
            <td style="width: 77.75pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;background: rgb(166, 166, 166);padding: 0cm 3.5pt;height: 30.75pt;vertical-align: bottom;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:13px;">N&deg; de Orden de Compra</span></strong></p>
            </td>
            <td style="width:57.85pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 3.5pt 0cm 3.5pt;height:30.75pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style='font-size:13px;font-family:"Arial","sans-serif";'>{{$ordencompra->nordencompra}}</span></strong></p>
            </td>
            <td style="height:30.75pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="3" style="width:288.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:13.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:16px;color:black;">1ra. Secci&oacute;n &nbsp; &nbsp; - Provincia Gran Chaco</span></strong></p>
            </td>
            <td style="width:56.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:13.5pt;"><br></td>
            <td style="width:77.75pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:#A6A6A6;padding:0cm 3.5pt 0cm 3.5pt;height:13.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:13px;">N&deg; de Preventivo</span></strong></p>
            </td>
            <td style="width:57.85pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:13.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style='font-size:13px;font-family:"Arial","sans-serif";'>{{$ordencompra->npreventivo}}</span></strong></p>
            </td>
            <td style="height:13.5pt;border:none;"><br></td>
        </tr>
        <tr>
            <td style="width:32.9pt;padding:0cm 3.5pt 0cm 3.5pt;height:18.0pt;"><br></td>
            <td colspan="2" style="width:255.1pt;padding:0cm 3.5pt 0cm 3.5pt;height:18.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:16px;color:black;">Tel/Fax: 46822039</span></strong></p>
            </td>
            <td style="width:56.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:18.0pt;"><br></td>
            <td style="width:69.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:18.0pt;"><br></td>
            <td style="width:77.75pt;border:solid windowtext 1.0pt;border-top:none;background:  #A6A6A6;padding:0cm 3.5pt 0cm 3.5pt;height:18.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:13px;">N&deg; Control Interno</span></strong></p>
            </td>
            <td style="width:57.85pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:18.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style='font-size:13px;font-family:"Arial","sans-serif";'>{{$ordencompra->numcontrolinterno}}</span></strong></p>
            </td>
            <td style="height:18.0pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="3" style="width:288.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Tarija - Bolivia</span></p>
            </td>
            <td style="width:56.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;"><br></td>
            <td style="width:69.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;"><br></td>
            <td style="width:77.75pt;border:solid windowtext 1.0pt;border-top:none;background:  #A6A6A6;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:13px;color:black;">N&deg; Hoja de Ruta</span></strong></p>
            </td>
            <td style="width:57.85pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="color:black;">{{$ordencompra->hojaruta}}</span></strong></p>
            </td>
            <td style="height:15.0pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="3" style="width:288.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:21.75pt;"><br></td>
            <td style="width:56.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:21.75pt;"><br></td>
            <td style="width:69.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:21.75pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">Lugar y Fecha:</span></strong></p>
            </td>
            <td colspan="2" style="width:135.6pt;padding:0cm 3.5pt 0cm 3.5pt;height:21.75pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:right;'><span style="font-size:13px;color:black;">Yacuiba, &nbsp; &nbsp; {{$fechaorden}} &nbsp;</span></p>
            </td>
            <td style="height:21.75pt;border:none;"><br></td>
        </tr>
        <tr>
            <td style="width:32.9pt;padding:0cm 3.5pt 0cm 3.5pt;height:.75pt;"><br></td>
            <td style="width:115.1pt;padding:0cm 3.5pt 0cm 3.5pt;height:.75pt;"><br></td>
            <td style="width:140.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:.75pt;"><br></td>
            <td style="width:56.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:.75pt;"><br></td>
            <td style="width:69.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:.75pt;"><br></td>
            <td style="width:77.75pt;padding:0cm 3.5pt 0cm 3.5pt;height:.75pt;"><br></td>
            <td style="width:57.85pt;padding:0cm 3.5pt 0cm 3.5pt;height:.75pt;"><br></td>
            <td style="height:.75pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="7" rowspan="3" style="width:548.6pt;padding:0cm 3.5pt 0cm 3.5pt;height:21.95pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:24px;color:black;">UNIDAD DE COMPRAS MENORES</span></strong></p>
            </td>
            <td style="height:21.95pt;border:none;"><br></td>
        </tr>
        <tr>
            <td style="height:21.95pt;border:none;"><br></td>
        </tr>
        <tr>
            <td style="height:21.95pt;border:none;"><br></td>
        </tr>
        <tr>
            <td style="width:32.9pt;padding:0cm 3.5pt 0cm 3.5pt;height:19.5pt;"><br></td>
            <td style="width:115.1pt;padding:0cm 3.5pt 0cm 3.5pt;height:19.5pt;"><br></td>
            <td colspan="3" style="width:265.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:19.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><u><span style="font-size:33px;color:black;">ORDEN DE COMPRA</span></u></strong></p>
            </td>
            <td style="width:77.75pt;padding:0cm 3.5pt 0cm 3.5pt;height:19.5pt;"><br></td>
            <td style="width:57.85pt;padding:0cm 3.5pt 0cm 3.5pt;height:19.5pt;"><br></td>
            <td style="height:19.5pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border:solid windowtext 1.0pt;border-right:solid black 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:21.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">APERTURA PROGRAM&Aacute;TICA:</span></strong></p>
            </td>
            <td colspan="5" style="width:400.6pt;border:solid windowtext 1.0pt;border-left:none;padding:  0cm 3.5pt 0cm 3.5pt;height:21.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">{{$ordencompra->approgramatica}}</span></p>
            </td>
            <td style="height:21.0pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:18.95pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">ACTIVIDAD / PROYECTO:</span></strong></p>
            </td>
            <td colspan="5" style="width:400.6pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:18.95pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">{{$ordencompra->actividad}}</span></p>
            </td>
            <td style="height:18.95pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:18.95pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">PARTIDA DE GASTO:</span></strong></p>
            </td>
            <td colspan="5" style="width:400.6pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:18.95pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">{{$ordencompra->partida}}</span></p>
            </td>
            <td style="height:18.95pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:18.95pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">UNIDAD SOLICITANTE:</span></strong></p>
            </td>
            <td colspan="5" style="width:400.6pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:18.95pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:13px;color:black;">&nbsp;{{$ordencompra->solicitante}}&nbsp;</span></p>
            </td>
            <td style="height:18.95pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">PROVEEDOR:</span></strong></p>
            </td>
            <td colspan="2" style="width:196.0pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:13px;color:black;">&nbsp;{{$ordencompra->representante}}&nbsp;</span></p>
            </td>
            <td style="width:69.0pt;border:solid windowtext 1.0pt;border-top:  none;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:12px;color:black;">C.I: {{$ordencompra->cedula}}</span></strong></p>
            </td>
            <td style="width:77.75pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:13px;color:black;">NIT &nbsp; &nbsp; {{$ordencompra->nitci}}</span></strong></p>
            </td>
            <td style="width:57.85pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:15.0pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="font-size:13px;color:black;">CEL: {{$ordencompra->telefono}}</span></strong></p>
            </td>
            <td style="height:15.0pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:20.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">MONTO TOTAL:</span></strong></p>
            </td>
            <td style="width:140.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;padding:  0cm 3.5pt 0cm 3.5pt;height:20.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style='font-size:13px;font-family:"Tahoma","sans-serif";'>Bs {{$ordencompra->precioreferencial}}</span></p>
            </td>
            <td colspan="4" style="width:260.6pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:20.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:13px;color:white;">diecinueve mil novecientos noventa y tres &nbsp;92/100 Bolivianos</span></p>
            </td>
            <td style="height:20.25pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:17.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">PLAZO:</span></strong></p>
            </td>
            <td style="width:140.0pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:17.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">{{$ordencompra->plazoentrega}} D&iacute;as Calendarios</span></p>
            </td>
            <td style="width:56.0pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:17.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">&nbsp;</span></p>
            </td>
            <td style="width:69.0pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:17.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">&nbsp;</span></p>
            </td>
            <td style="width:77.75pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:17.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">&nbsp;</span></p>
            </td>
            <td style="width:57.85pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:17.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">&nbsp;</span></p>
            </td>
            <td style="height:17.25pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:20.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:14px;color:black;">MODALIDAD DE CONTRATACI&Oacute;N:</span></strong></p>
            </td>
            <td colspan="5" style="width:400.6pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:20.25pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">{{$ordencompra->modalidadcontratacion}}</span></p>
            </td>
            <td style="height:20.25pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border:solid windowtext 1.0pt;border-top:none;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:28.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">OBJETO DE LA CONTRATACI&Oacute;N:</span></strong></p>
            </td>
            <td colspan="5" style="width:400.6pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:28.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:13px;color:black;">&nbsp;&nbsp;</span></p>
            </td>
            <td style="height:28.5pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:19.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">FORMA DE ENTREGA:</span></strong></p>
            </td>
            <td colspan="5" style="width:400.6pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid black 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:19.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:13px;color:black;">&nbsp;POR EL TOTAL &nbsp; &nbsp;&nbsp;</span></p>
            </td>
            <td style="height:19.5pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="width:148.0pt;border:solid windowtext 1.0pt;border-top:none;background:#BFBFBF;padding:0cm 3.5pt 0cm 3.5pt;height:28.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">FORMA DE PAGO:</span></strong></p>
            </td>
            <td colspan="5" style="width:400.6pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0cm 3.5pt 0cm 3.5pt;height:28.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:13px;color:black;">&nbsp;EL PAGO &Uacute;NICO SE EFECTUARA SOBRE EL TOTAL DEL MONTO ADJUDICADO, PREVIO INFORME DE CONFORMIDAD Y LA PRESENTACI&Oacute;N DE LA FACTURA CORRESPONDIENTE.&nbsp;</span></p>
            </td>
            <td style="height:28.5pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="7" style="width:548.6pt;border:none;padding:0cm 3.5pt 0cm 3.5pt;height:34.5pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">Conforme a &nbsp;PROPUESTA presentada y de acuerdo a las Especificaciones Tecnicas / Terminos de Referencia, elaboradas por la Unidad Solicitante agradeceremos &nbsp;a Ud. sirva realizar la siguiente compra:</span></p>
            </td>
            <td style="height:34.5pt;border:none;"><br></td>

            
        </tr>

        <table style="margin: 0 auto;" width="80%" border="1" style="font-size:10px;color:black">
                <tr>

                    <th style="background:#A6A6A6;">N°</th>
                    <th style="background:#A6A6A6;">NOMBRE DEL PRODUCTO</th>
                    <th style="background:#A6A6A6;">ESPECIFICACIONES TECNICAS</th>
                    <th style="background:#A6A6A6;">UNIDAD</th>
                    <th style="background:#A6A6A6;">CANTIDAD</th>
                    <th style="background:#A6A6A6;">PRECIO UNITARIO</th>
                    <th style="background:#A6A6A6;">PRECIO TOTAL</th>



                </tr>
                @forelse ($prodserv as $key =>$prod)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{ $prod -> nombreprodserv}}</td>
                    <td>{{ $prod -> detalleprodserv}}</td>
                    <td>{{ $prod -> nombreumedida}}</td>
                    <td>{{ $prod -> cantidad}}</td>
                    <td>{{ $prod -> precio}}</td>
                    <td>{{ $prod -> subtotal}}</td>



                </tr>
                @empty

                @endforelse

            </table>
<table style="border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width: 41.3pt;border: 1pt solid windowtext;padding: 0cm 5.4pt;height: 21.75pt;vertical-align: top;"><br></td>
            <td colspan="2" style="width: 377pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 21.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>Son:  {{$valor_total2}}</strong></p>
            </td>
            <td style="width: 76pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 21.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>&nbsp;</strong></p>
            </td>
            <td style="width: 68pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 21.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong> {{$valor_total}}</strong></p>
            </td>
            <td style="height:21.75pt;border:none;"><br></td>
        </tr>
        <tr>
            <td style="width: 41.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 15pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>LUGAR</strong></p>
            </td>
            <td style="width: 156.8pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 15pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>FECHA DE INICIO</strong></p>
            </td>
            <td style="width: 220.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 15pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>FECHA DE CONCLUSI&Oacute;N</strong></p>
            </td>
            <td colspan="2" style="width: 144pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 15pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>CONDICIONES DE PAGO</strong></p>
            </td>
            <td style="height:15.0pt;border:none;"><br></td>
        </tr>
        <tr>
            <td rowspan="2" style="width: 41.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 24.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>YACUIBA</p>
            </td>
            <td rowspan="2" style="width: 156.8pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 24.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>{{$ordencompra->fechainicio}}</p>
            </td>
            <td rowspan="2" style="width: 220.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 24.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>{{$ordencompra->fechaconclusion}}</p>
            </td>
            <td colspan="2" rowspan="2" style="width: 144pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 24.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>PAGO &Uacute;NICO &nbsp;CON CHEQUE A LA ENTREGA DEL BIEN</p>
            </td>
            <td style="height:24.75pt;border:none;"><br></td>
        </tr>
        <tr>
            <td style="height:13.45pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="3" style="width: 418.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 15.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>APROBACI&Oacute;N</strong></p>
            </td>
            <td colspan="2" style="width: 144pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 15.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>ACEPTACI&Oacute;N</strong></p>
            </td>
            <td style="height:15.75pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="3" rowspan="4" style="width: 418.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 15pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            </td>
            <td colspan="2" rowspan="4" style="width: 144pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 15pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>&nbsp;</p>
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
            <td style="height:25.5pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="3" style="width: 418.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 33.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>RESPONSABLE PROCESO DE CONTRATACI&Oacute;N - RPA &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FIRMA Y SELLO</strong></p>
            </td>
            <td colspan="2" style="width: 144pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 33.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong>PROVEEDOR &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FIRMA Y SELLO</strong></p>
            </td>
            <td style="height:33.75pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="5" style="width: 562.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 42pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><u>Decreto Supremo No 956, Articulo 2, Parrafo I, &nbsp;se modifica el insiso cc), &nbsp;con el siguiente texto: &nbsp;cc) Orden de Compra u Orden de Servicio:</u>&nbsp;</strong>Es una solicitud escrita que formaliza un proceso de contrataci&oacute;n, que ser&aacute; aplicable s&oacute;lo en casos de adquisici&oacute;n de bienes o servicios generales de entrega o prestaci&oacute;n, en un plazo no mayor a quince ( 15 ) &nbsp;d&iacute;as calendario.&rdquo;</p>
            </td>
            <td style="height:42.0pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="5" style="width: 562.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 15pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'><strong><u>NOTA:</u></strong></p>
            </td>
            <td style="height:15.0pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="5" style="width: 562.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>*En caso de incumplimiento con la entrega del bien se proceder&aacute; de acuerdo a normativa vigente.</p>
            </td>
            <td style="height:13.5pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="5" style="width: 562.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>* Los gastos no consignados en la presente ORDEN no ser&aacute;n reconocidos.</p>
            </td>
            <td style="height:13.5pt;border:none;"><br></td>
        </tr>
        <tr>
            <td colspan="5" style="width: 562.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 15.75pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  normal;font-size:15px;font-family:"Calibri","sans-serif";'>* La entrega deber&aacute; efectuarse con ACTA DE RECEPCI&Oacute;N</p>
            </td>
            <td style="height:15.75pt;border:none;"><br></td>
        </tr>
    </tbody>
</table>

        
        </tr>

   
        
      
    </tbody>
</table>
   
</div>
@endsection
