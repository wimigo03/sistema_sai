@extends('layouts.dashboard')
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

            <table border="1"  cellspacing="0" cellpadding="0" width="100%" style=" border: 1px solid black;border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td colspan="10" width="707" style="font-size: 12px;" align="right">
                            <h:inputHidden value="#{comprasController.idcompraStatic}" />

                           Yacuiba, 27 de septiembre de 2021

                        </td>

                    </tr>
                    <tr align="center">
                        <td rowspan="4" width="105">

                            <img src="{{ asset('logos/logo.png') }}" width="120px" height="80px" />
                        </td>
                        <td colspan="8" width="501" style="font-size: 12px;" align="center">
                             GOBIERNO AUT&Oacute;NOMO REGIONAL DEL GRAN
                            CHACO-YACUIBA
                        </td>
                        <td rowspan="2" width="101" style="font-size: 12px;">
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
                        <td colspan="8" rowspan="3" width="501" style="font-size: 12px;">
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
                        <td width="101" style="font-size: 12px;">
                            {{$compras->controlinterno}}
                        </td>

                    </tr>
                    <tr>
                        <td width="101" style="font-size: 12px;">
                            {{$datos->nombrearea}}
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 12px;">
                            NOMBRE Y CARGO
                            <p />
                            DEL SOLICITANTE:
                        </td>
                        <td colspan="8" width="564" style="font-size: 12px;">
                            {{$encargado->abrev}} {{$encargado->nombres}} {{$encargado->ap_pat}} {{$encargado->ap_mat}}
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 12px;">
                            &Aacute;REA FUNCIONAL
                            <p />
                            O SOLICITANTE
                        </td>
                        <td colspan="8" width="564" style="font-size: 12px;">
                            {{$datos->nombrearea}}
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 12px;">

                            JUSTIFICACI&Oacute;N
                        </td>
                        <td colspan="8" width="564" style="font-size: 12px;">

                            {{$compras->justificacion}}

                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 12px;">
                            PROGRAMA
                            <P />
                            PROYECTO
                            <p />
                            ACTIVIDAD
                        </td>
                        <td colspan="8" width="564" style="font-size: 12px;">
                            {{$compras->nombreprograma}}
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" width="143" style="font-size: 12px;">
                            CATEGOR&Iacute;A PROGRAM&Aacute;TICA
                        </td>
                        <td colspan="8" width="564" style="font-size: 12px;">
                            {{$compras->codcatprogramatica}}
                        </td>

                    </tr>
                    <tr>
                        <td colspan="10" width="707" style="font-size: 12px;">


                            <table border="1"  cellspacing="0" cellpadding="0" width="100%" style=" border: 1px solid black;border-collapse: collapse;font-size: 10px;">
                                <thead>
                                    <th style="font-size: 10px;">Nro</th>
                                    <th style="font-size: 10px;">NOMBRE DEL BIEN</th>
                                    <th style="font-size: 10px;">DETALLE Y ESPECIFICACIONES TECNICAS</th>
                                    <th style="font-size: 10px;">PARTIDA</th>
                                    <th style="font-size: 10px;">U.MEDIDA</th>
                                    <th style="font-size: 10px;">CANTIDAD </th>
                                    <th style="font-size: 10px;">PRECIO-U.</th>
                                    <th style="font-size: 10px;">SUBTOTAL </th>



                                </thead>
                                @php
                                $num = 1;
                                @endphp
                                @foreach($prodserv as $prod)
                                <tr>
                                    <td class="text-justify p-1">{{$num++}}</td>
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
                        <td colspan="4" width="187" style="font-size: 12px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-align: center">FIRMA Y SELLO</p>
                            <p style="text-align: center">ADMINISTRADOR </p>
                        </td>
                        <td colspan="2" width="189" style="font-size: 12px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-align: center">FIRMA Y SELLO</p>
                            <p style="text-align: center">INMEDIATO SUPERIOR </p>
                        </td>
                        <td colspan="2" width="180" style="font-size: 12px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-align: center">FIRMA Y SELLO</p>
                            <p style="text-align: center">VºBº SECRETARIO</p>
                        </td>
                        <td colspan="2" width="152" style="font-size: 12px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-align: center">FIRMA Y SELLO</p>
                            <p style="text-align: center">DIRECTORA ADMINISTRATIVA</p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="8" width="555" style="font-size: 12px;">
                            <p>&nbsp;</p>
                            &nbsp;&nbsp;&nbsp; PARA EL LLENADO EN EL &Aacute;REA ADMINISTRATIVA.
                        </td>
                        <td colspan="2" width="152" style="font-size: 12px;">
                            <p>CONTROL&nbsp; INTERNO</p>
                            N&ordm; 1-SISTEMAS
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" rowspan="2" width="182" style="font-size: 12px;">
                            <p>&nbsp;</p>
                            <p>ALMACEN O ACTIVOS FIJOS</p>

                        </td>
                        <td colspan="7" width="525" style="font-size: 12px; align">
                            <p style="text-align:center">CERTIFICACI&Oacute;N DE PRESUPUESTO</p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="7" width="525" style="font-size: 12px;">
                            <p style="text-align:center">ASIGNACI&Oacute;N O IMPUTACI&Oacute;N PRESUPUESTARIA</p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" width="182" style="font-size: 12px;">
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
                        <td colspan="7" width="525" style="font-size: 12px;">
                            <table border="1"  cellspacing="0" cellpadding="0" width="100%" style=" border: 1px solid black;border-collapse: collapse;">
                                <thead>
                                    <th style="font-size: 10px;" class="text-justify p-1">CATEG. PROGRAMATICA</th>
                                    <th style="font-size: 10px;" class="text-center p-1">PARTIDA</th>
                                    <th style="font-size: 10px;" class="text-center p-1">NOMBRE DE LA PARTIDA</th>
                                    <th style="font-size: 10px;" class="text-center p-1">FUENTE DE FINANC.</th>
                                    <th style="font-size: 10px;" class="text-center p-1">N° PREV.</th>
                                    <th style="font-size: 10px;" class="text-center p-1">IMPORTE (Bs.) </th>




                                </thead>


                                <tr style="height:30px;">
                                    <td class="text-justify p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>


                                </tr>
                                <tr style="height:30px;">
                                    <td class="text-justify p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>


                                </tr>
                                <tr style="height:30px;">
                                    <td class="text-justify p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>


                                </tr>
                                <tr style="height:30px;">
                                    <td class="text-justify p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>


                                </tr>
                                <tr style="height:30px;">
                                    <td class="text-justify p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>


                                </tr>
                                <tr style="height:30px;">
                                    <td class="text-justify p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>


                                </tr>
                                <tr style="height:30px;">
                                    <td class="text-justify p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>
                                    <td class="text-center p-1">  </td>


                                </tr>

                            </table>

                        </td>

                    </tr>
                    <tr>
                        <td colspan="5" width="223" style="font-size: 12px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-align:center"> FIRMA Y SELLO</p>
                            <p style="text-align:center"> DE ALMACEN O ACTIVOS</p>
                        </td>
                        <td colspan="2" width="244" style="font-size: 12px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-align:center">
                                FIRMA Y SELLO</p>
                                <p style="text-align:center">
                                    DE PRESUPUESTOS</p>
                        </td>
                        <td colspan="3" width="240" style="font-size: 12px;">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p style="text-align:center">FIRMA Y SELLO</p>
                            <p style="text-align:center">RESPONSABLE DE CONTRATACIONES MENORES(RPA)</p>
                        </td>

                    </tr>
                </tbody>
            </table>

        </div>
    </h:form>


</div>
@endsection
