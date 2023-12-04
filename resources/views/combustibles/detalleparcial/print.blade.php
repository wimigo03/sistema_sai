
@if(Session::has('message'))
<div class="alert alert-success">
    <em> {!! session('message') !!}</em>
</div>
@endif


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
<div style="width: 900px;margin: auto;">


    <button data-id="5" onclick="javascript:imprSelec('muestra')">Imprimir</button>
    </div>



<div id="muestra" style="width: 900px;margin: auto;">


    <table border="0"  cellspacing="0" cellpadding="0" width="100%" >
        <tbody>
            <tr >
                <td width="392" nowrap="" colspan="3" valign="bottom" style="font-size: 18px;">
                    <p align="center">
                        <b>

                            <a name="RANGE!A1:G104">
                                Gobierno Autónomo Regional Del Gran Chaco
                            </a>
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="73" nowrap="">
                </td>
                <td width="95" nowrap="" rowspan="2">
                    <p align="center">
                        <b>

                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="104" style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                    <p align="center">
                        <b>
                            N° de Orden de Compra
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="87" style=" border: 1px solid black;border-collapse: collapse;">
                    <p align="center">
                        <b>
                            {{$compras->controlinterno}}

                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="0" height="50">
                </td>
            </tr>
            <tr>
                <td width="392" nowrap="" colspan="3" style="font-size: 18px;">
                    <p align="center">
                        <b>
                            1ra. Sección  - Provincia Gran Chaco
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="73" nowrap="">
                </td>
                <td width="104"  style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                    <p align="center">
                        <b>
                            N° de Preventivo
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="87" style=" border: 1px solid black;border-collapse: collapse;">
                    <p align="center">
                        <b>
                            {{$compras->preventivo}}
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="0" height="25">
                </td>
            </tr>
            <tr>
                <td width="392" nowrap="" colspan="3">
                    <p align="center">
                        <b>
                            Tel/Fax: 46822039
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="73" >
                </td>
                <td width="95" >
                </td>
                <td width="104" style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                    <p align="center">
                        <b>
                            N° Hoja de Ruta
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="87" style=" border: 1px solid black;border-collapse: collapse;">
                    <p align="center">
                        <b>
                            {{$compras->numcompra}}
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="0" height="26">
                </td>
            </tr>
            <tr>
                <td width="392" nowrap="" colspan="3">
                    <p align="center">
                        <b>
                            Tarija - Bolivia
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="250" nowrap="">
                </td>
                <td width="95" nowrap="">
                    <p>
                        <b>
                            Lugar y Fecha:
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="191" nowrap="" colspan="2">
                    <p align="right">
                        Yacuiba,  12 de enero de 2023
                        <p>
                        </p>
                    </p>
                </td>
                <td width="0" height="28">
                </td>
            </tr>
            <tr>
                <td width="751" colspan="7" rowspan="2">
                    <p align="center">
                        <b style="font-size: 20px">
                            UNIDAD DE COMPRAS MENORES
                            <p>
                            </p>
                        </b>
                    </p>
                </td>

            </tr>
            <tr>
                <td width="0" height="37">
                </td>
            </tr>
            <tr>
                <td width="43" nowrap="">
                </td>
                <td width="139" nowrap="">
                </td>
                <td width="379" nowrap="" colspan="3">
                    <p align="center">
                        <b style="font-size: 30px">
                            ORDEN DE COMPRA
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="104" nowrap="">
                </td>
                <td width="87" nowrap="">
                </td>
                <td width="0" height="43">
                </td>
            </tr>
        </tbody>
    </table>


    <table border="1"  cellspacing="0" cellpadding="0" width="100%" style=" border: 1px solid black;border-collapse: collapse;">
    <tbody>

        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb">
                <p>
                    <b>
                        &nbsp;ACTIVIDAD / PROYECTO:
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="569" colspan="5" >
                <p>
                    &nbsp;{{$compras->justificacion}}&nbsp;
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="36" >
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb">
                <p>
                    <b>
                        &nbsp; UNIDAD SOLICITANTE:
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="569" colspan="5" >
                <p>
                    &nbsp; {{$compras->justificacion}} &nbsp;
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="30">
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb">
                <p>
                    <b>
                        &nbsp; PROVEEDOR:
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="569" colspan="5" >
                <p>
                    &nbsp; {{$compras->nombreproveedor}}
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="30">
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb">
                <p>
                    <b>
                        &nbsp; REPRESENTANTE LEGAL:
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="284" colspan="2" >
                <p>
                    &nbsp; {{$compras->representanteproveedor}} &nbsp;
                    <p>
                    </p>
                </p>
            </td>
            <td width="95" nowrap="" style="background-color:#b9d6eb">
                <p align="center" >
                    <b>
                        &nbsp;  C.I.  {{$compras->cedulaproveedor}}&nbsp;
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="104" nowrap="" style="background-color:#b9d6eb">
                <p align="center">
                    <b>
                        &nbsp; NIT. {{$compras->nitciproveedor}} &nbsp;
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="87" nowrap="" style="background-color:#b9d6eb">
                <p align="center">
                    <b>
                        &nbsp; CEL: {{$compras->telefonoproveedor}} &nbsp;
                        <p>
                        </p>
                    </b>
                </p>
            </td>

        </tr>
        <tr >
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb">
                <p>
                    <b>
                        &nbsp; MONTO TOTAL: &nbsp;
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="569" nowrap="" colspan="5" >
                <p>
                    &nbsp; Bs {{$valor_total}} &nbsp;
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="30">
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb" >
                <p>
                    <b>
                        &nbsp;  PLAZO: &nbsp;
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="569" nowrap="" colspan="5" >
                <p>
                    &nbsp;  3 DÍAS CALENDARIOS, A PARTIR DEL SIGUIENTE DÍA HÁBIL  DE LA
                    SUSCRIPCIÓN DE LA ORDEN DE COMPRA &nbsp;
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="30">
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb">
                <p>
                    <b>
                        &nbsp; MODALIDAD DE CONTRATACIÓN: &nbsp;
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="569" nowrap="" colspan="5" >
                <p>
                    &nbsp;  CONTRATACIÓN MENOR &nbsp;
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="30">
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb">
                <p>
                    <b>
                        &nbsp; OBJETO DE LA CONTRATACIÓN: &nbsp;
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="569" colspan="5" >
                <p>
                    &nbsp;  ADQUISICIÓN DE BECAS ALIMENTARIAS  PARA EL ALBERGUE DE NIÑOS NUEVO AMANECER, CORRESPONDIENTE AL MES DE ENERO DE
                    2023 &nbsp;
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="50">
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb">
                <p>
                    <b>
                        &nbsp; LUGAR DE ENTREGA: &nbsp;
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="569" colspan="5" >
                <p>
                    &nbsp; EN ALMACÉN CENTRAL DEL GOBIERNO AUTÓNOMO REGIONAL DEL GRAN
                    CHACO. &nbsp;
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="36">
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb">
                <p>
                    <b>
                        &nbsp;  FORMA DE PAGO: &nbsp;
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="569" colspan="5" >
                <p>
                    &nbsp;   EL PAGO ÚNICO SE EFECTUARA VÍA ELECTRÓNICA- SIGEP,   SOBRE
                    EL TOTAL DEL MONTO ADJUDICADO, PREVIO INFORME DE
                    CONFORMIDAD Y LA PRESENTACIÓN DE LA FACTURA
                    CORRESPONDIENTE. &nbsp;
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="58">
            </td>
        </tr>
        <tr>
            <td width="751" colspan="7">
                <p>
                    &nbsp; Conforme a la propuesta Técnica Económica presentada y de
                    acuerdo a las Especificaciones Técnicas , elaboradas por la
                    Unidad Solicitante agradeceremos  a Ud. sirva realizar la
                    siguiente provisión:
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="49">
            </td>
        </tr>


        <tr>
            <td colspan="10" width="707" style="font-size: 12px;">


                <table border="1"  cellspacing="0" cellpadding="0" width="100%" style=" border: 1px solid black;border-collapse: collapse;">
                    <thead>
                        <th style="font-size: 10px;" class="text-justify p-1">Nro</th>
                        <th style="font-size: 10px;" class="text-center p-1">NOMBRE</th>
                        <th style="font-size: 10px;" class="text-center p-1">ESPECIFICACIONES TECNICAS</th>
                        <th style="font-size: 10px;" class="text-center p-1">PARTIDA</th>
                        <th style="font-size: 10px;" class="text-center p-1">CANTIDAD </th>
                        <th style="font-size: 10px;" class="text-center p-1">PRECIO-U.</th>
                        <th style="font-size: 10px;" class="text-center p-1">SUBTOTAL </th>



                    </thead>
                    @php
                    $num = 1;
                    @endphp
                    @foreach($prodserv as $prod)
                    <tr style="text-align: center">
                        <td class="text-justify p-1">{{$num++}}</td>
                        <td class="text-center p-1">{{$prod ->nombreprodcomb}}</td>
                        <td class="text-center p-1">{{$prod ->detalleprodcomb}}</td>
                        <td class="text-center p-1">{{$prod ->codigopartida}}</td>
                        <td class="text-center p-1">{{$prod ->cantidad}}</td>
                        <td class="text-center p-1">{{$prod ->precio}}</td>
                        <td class="text-center p-1">{{$prod ->precio * $prod ->cantidad}}</td>

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
            <td width="664" nowrap="" colspan="6" >
                <p>
                    <b>
                        SON: DOCE MIL  00/100 BOLIVIANOS
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="87" nowrap="" >
                <p align="center">
                    <b>
                        12.000,00
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="0" height="28">
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                <p align="center">
                    <b>
                        LUGAR
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="284" nowrap="" colspan="2" style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                <p align="center">
                    <b>
                        FECHA DE INICIO
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="285" nowrap="" colspan="3" style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                <p align="center">
                    <b>
                        FECHA DE CONCLUSION
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="0" height="48">
            </td>
        </tr>
        <tr>
            <td width="181" nowrap="" colspan="2" >
                <p align="center">
                    YACUIBA
                    <p>
                    </p>
                </p>
            </td>
            <td width="284" nowrap="" colspan="2" >
                <p align="center">
                    13/1/2023
                    <p>
                    </p>
                </p>
            </td>
            <td width="285" nowrap="" colspan="3" >
                <p align="center">
                    15/1/2023
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="29">
            </td>
        </tr>
        <tr>
            <td width="560" nowrap="" colspan="5" style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                <p align="center">
                    <b>
                        APROBACIÓN
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="191" colspan="2" style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                <p align="center">
                    <b>
                        ACEPTACIÓN
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="0" height="44" >
            </td>
        </tr>
        <tr >
            <td width="560" colspan="5" rowspan="3" >
            </td>
            <td width="191" colspan="2" rowspan="3" >
            </td>
            <td width="0" height="34" >
            </td>
        </tr>
        <tr >
            <td width="0" height="148">
            </td>
        </tr>
        <tr >
            <td width="0" height="34">
            </td>
        </tr>
        <tr>
            <td width="560" colspan="5" style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                <p align="center">
                    <b>
                        RESPONSABLE DE PROCESO DE CONTRATACIÓN
                        (R.P.A)

                    </b>
                    <b>FIRMA Y SELLO</b>
                    <b>
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="191" colspan="2" style="background-color:#b9d6eb;border: 1px solid black;border-collapse: collapse;">
                <p align="center">
                    <b>
                        PROVEEDOR
                    </b>
                    <b>FIRMA Y SELLO</b>
                    <b>
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="0" height="56">
            </td>
        </tr>
        <tr>
            <td width="751" colspan="7" >
                <p>
                    <b>
                        <u>
                            &nbsp;  Decreto Supremo No 956, Articulo 2, Párrafo I,  se
                            modifica el inciso cc),  con el siguiente texto:
                            cc) Orden de Compra u Orden de Servicio:
                        </u>
                    </b>
                    <b> </b>
                    &nbsp;  Es una solicitud escrita que formaliza un proceso de
                    contratación, que será aplicable sólo en casos de
                    adquisición de bienes o servicios generales de entrega o
                    prestación, en un plazo no mayor a quince ( 15 )  días
                    calendario.”
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="64">
            </td>
        </tr>
        <tr>
            <td width="751" nowrap="" colspan="7" >
                <p>
                    <b>
                        <u>
                              NOTA:
                            <p>
                            </p>
                        </u>
                    </b>
                </p>
            </td>
            <td width="0" height="30">
            </td>
        </tr>
        <tr>
            <td width="751" colspan="7">
                <p>
                    &nbsp; * En cumplimiento al Artículo 13, inciso f),  numeral 2 del
                    Reglamento Específico de Sistema de Administración de
                    Bienes y Servicios  RE-SABS, aprobado y compatibilizado por
                    el Ministerio de Economía y Finanzas Publicas.
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="43">
            </td>
        </tr>
        <tr>
            <td width="751" colspan="7">
                <p>
                    &nbsp; * Conforme a la Resolución Administrativa Nº 25/2021-
                    Artículo Primero, a) Delegación de Responsable de Proceso
                    de Contratación RPA.
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="24">
            </td>
        </tr>
        <tr>
            <td width="751" colspan="7">
                <p>
                    &nbsp; * En caso de incumplimiento con la entrega del bien se
                    procederá de acuerdo a normativa vigente.
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="24">
            </td>
        </tr>
        <tr>
            <td width="751" nowrap="" colspan="7">
                <p>
                    &nbsp;  * Los gastos no consignados en la presente ORDEN no serán
                    reconocidos.
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="24">
            </td>
        </tr>
        <tr>
            <td width="751" nowrap="" colspan="7">
                <p>
                    &nbsp; * La entrega deberá efectuarse con ACTA DE RECEPCIÓN.
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="24">
            </td>
        </tr>
    </tbody>
</table>

</div>

