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
<span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
    <a href="{{url()->previous()}}">
        <span class="color-icon-1">
            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
        </span>
    </a>
</span>

<a onclick="javascript:imprSelec('muestra')"><button class="btn btn-link">Imprimir</button></a>

<div id="muestra">

    <h:form prependId="false" style="background: #ffffff ">
        <div align="center">

            <table border=1 cellspacing=0 cellpadding=1>
                <tbody>
                    <tr>
                        <td colspan="10" width="707" style="font-size: 10px;" align="right">
                            <h:inputHidden value="#{comprasController.idcompraStatic}" />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


                            <h:outputText value="Yacuiba, 27 de septiembre de 2021" style="font-size: 11px;" />

                        </td>

                    </tr>
                    <tr align="center">
                        <td rowspan="4" width="105">

                            <img src="{{ asset('logos/logo.png') }}" width="120px" height="80px" />
                        </td>
                        <td colspan="8" width="501" style="font-size: 11px;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GOBIERNO AUT&Oacute;NOMO REGIONAL DEL GRAN
                            CHACO-YACUIBA
                        </td>
                        <td rowspan="2" width="101" style="font-size: 11px;">
                            <div align="center">
                                CONTROL
                                <P />
                                INTERNO
                                <P />
                                Nº
                            </div>


                        </td>

                    </tr>
                    <tr>
                        <td colspan="8" rowspan="3" width="501" style="font-size: 11px;">
                            <div align="center">
                                SECRETARIA REGIONAL DE ECONOMIA Y FINANZAS PUBLICAS
                                <P />
                                SOLICITUD DE BINES Y MATERIALES
                                <P />
                                (Compras Menores hasta Bs. 50.000)
                            </div>
                        </td>
                    </tr>
                    <tr align="center">
                        <td width="101" style="font-size: 11px;">
                            1
                        </td>

                    </tr>
                    <tr>
                        <td width="101" style="font-size: 11px;">
                            SISTEMAS
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 11px;">
                            NOMBRE Y CARGO
                            <p />
                            DEL SOLICITANTE:
                        </td>
                        <td colspan="8" width="564" style="font-size: 11px;">
                            Ing. Wilson Mart&iacute;nez-Jefe de la Unidad de Sistemas
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 11px;">
                            &Aacute;REA FUNCIONAL
                            <p />
                            O SOLICITANTE
                        </td>
                        <td colspan="8" width="564" style="font-size: 11px;">

                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 11px;">

                            JUSTIFICACI&Oacute;N
                        </td>
                        <td colspan="8" width="564" style="font-size: 11px;">
                            {{$compras->justificacion}}
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 11px;">
                            PROGRAMA
                            <P />
                            PROYECTO
                            <p />
                            ACTIVIDAD
                        </td>
                        <td colspan="8" width="564" style="font-size: 11px;">
                            {{$compras->nombreprograma}}
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 11px;">
                            CATEGOR&Iacute;A PROGRAM&Aacute;TICA
                        </td>
                        <td colspan="8" width="564" style="font-size: 11px;">
                            16.0.20
                        </td>

                    </tr>
                    <tr>
                        <td colspan="10" width="707" style="font-size: 11px;">
                            </p>

                            <table id="empleados" border=1 cellspacing=0 cellpadding=1 style="width:100%; font-size: 11px;">
                                <thead>
                                    <th>OBJETO DE CONTRATACION</th>
                                    <th>DETALLE DE ESPECIFICACIONES TECNICAS</th>
                                    <th>PARTIDA</th>
                                    <th>U.MEDIDA</th>
                                    <th>CANTIDAD </th>
                                    <th>PRECIO </th>
                                    <th>SUBTOTAL </th>



                                </thead>

                                @foreach($prodserv as $prod)
                                <tr>
                                    <td class="text-center p-1">{{$prod -> nombreprodserv}}</td>
                                    <td class="text-center p-1">{{$prod -> detalleprodserv}}</td>
                                    <td class="text-center p-1">{{$prod -> codigopartida}}</td>
                                    <td class="text-center p-1">{{$prod -> nombreumedida}}</td>
                                    <td class="text-center p-1">{{$prod -> cantidad}}</td>
                                    <td class="text-center p-1">{{$prod -> precio}}</td>
                                    <td class="text-center p-1">{{$prod -> precio * $prod -> cantidad}}</td>

                                </tr>
                                @endforeach
                     @if (count($prodserv) > 0)
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-center p-1">
                                <b>TOTAL:</b>
                            </td>

                            <td class="text-center p-1">
                                <b>{{$valor_total}}</b>
                            </td>

                        </tr>
                    @endif
                            </table>


                        </td>

                    </tr>
                    <tr>
                        <td colspan="4" width="187" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>FIRMA Y SELLO</p>
                        </td>
                        <td colspan="2" width="189" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>FIRMA Y SELLO</p>
                        </td>
                        <td colspan="2" width="180" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>FIRMA Y SELLO</p>
                        </td>
                        <td colspan="2" width="152" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>FIRMA Y SELLO</p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="8" width="555" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            &nbsp;&nbsp;&nbsp; PARA EL LLENADO EN EL &Aacute;REA ADMINISTRATIVA.
                        </td>
                        <td colspan="2" width="152" style="font-size: 11px;">
                            <p>CONTROL&nbsp; INTERNO</p>
                            N&ordm; 1-SISTEMAS
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" rowspan="2" width="182" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>ALMAC&Eacute;N O ACTIVOS</p>
                            <p>FIJOS</p>
                        </td>
                        <td colspan="7" width="525" style="font-size: 11px;">
                            <p>CERTIFICACI&Oacute;N DE PRESUPUESTO</p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="7" width="525" style="font-size: 11px;">
                            <p>ASIGNACI&Oacute;N O IMPUTACI&Oacute;N PRESUPUESTARIA</p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" width="182" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (NO
                                EXISTE)</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (SI
                                EXISTE)</p>
                        </td>
                        <td colspan="7" width="525" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                AQU&Iacute; LA TABLA 2</p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="5" width="223" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIRMA Y SELLO</p>
                        </td>
                        <td colspan="2" width="244" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                FIRMA Y SELLO</p>
                        </td>
                        <td colspan="3" width="240" style="font-size: 11px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FIRMA Y SELLO</p>
                        </td>

                    </tr>
                </tbody>
            </table>

        </div>
    </h:form>


</div>
@endsection
