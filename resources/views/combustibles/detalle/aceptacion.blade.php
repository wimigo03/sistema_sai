
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
    // TODO: BOTON DE IMPRIMIR
<button data-id="5" onclick="javascript:imprSelec('muestra')">
    Imprimir</button>
</div>
<div id="muestra" style="width: 900px;margin: auto;">

    <table width="100%" style="font-size: 13px">
        <tr>
            <td align="right">
                Yacuiba, {{$fechaInvitacion}}
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                Sr.
            </td>
        </tr>
        <tr>
            <td>
                {{$responsables->nombrerespcontrat}}
            </td>
        </tr>
        <tr>
            <td>
                <b>RESPONSABLE DEL PROCESO DE CONTRATACIÓN (RPA)</b>
                <br>
                <b>GOBIERNO AUTONOMO REGIONAL DEL GRAN CHACO</b>
            </td>
        </tr>
        <tr>
            <td>
                Referente.-
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <b>REF.: ACEPTACIÓN A LA INVITACIÓN REALIZADA EN EL PROCESO DE CONTRATACIÓN MENOR</b>
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
                Mediante la presente manifiesto mi aceptación a invitación recibida en fecha {{$fechaInvitacion}}, para el
                Proceso de Contratación denominado {{$ordencompra->nombrecompra}} , adjunto a la misma la documentación solicitada:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <p>
            @forelse ($ordendoc as $key => $value)
            <tr >

                <td> {{$key+1 . '.- ' . $value -> nombredoc}}</td>

            </tr>
            @empty

            @endforelse
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                Sin otro particular motivo esperando una respuesta positiva me despido con la mayor consideración.
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Atentamente</td>
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
                {{$ordencompra->representante}}
            </td>
        </tr>
        <tr>
            <td align="center">
                <b>C.I.N&deg; {{$ordencompra->cedula}}</b>
            </td>
        </tr>
    </table>
</div>

