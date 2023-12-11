

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
<div id="muestra"  style="width: 900px;margin: auto;">

    <table width="100%" style="font-size: 12px" >
        <tr>
            <td align="right">
                Yacuiba, {{$fechaInvitacion}}
            </td>
        </tr>
        <tr>
            <td align="right">
                CITE: {{$ordencompra->codciteinvitacion}}
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                Señor(a):<p>
            </td>
        </tr>
        <tr>

            <td>
                {{$ordencompra->proveedor}}
            </p>

                <u><b>Proponente</b></u>
            </td>

        </tr>


        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <b>REF.: INVITACIÓN PARA EL PRESENTE PROCESO DE CONTRATACIÓN MENOR.</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                De mi mayor consideración:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                El Gobierno Autónomo Regional del Gran Chaco, a través del Responsable del Proceso de Contratación
                de apoyo nacional a la producción y empleo R.P.A., designado mediante Resolución Administrativa Nº 25/2021 de fecha
                8 de Julio de 2021, en el marco de sus atribuciones, tiene a bien invitarle a participar del Proceso de Contratación, para
                tal efecto adjunto especificaciones técnicas presentados por la unidad solicitante, bajo la Modalidad de Contratación Menor denominado.
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >
                <b>{{$ordencompra->nombrecompra}}</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                En caso de aceptación, deberá presentar la documentación requerida de acuerdo a las Especificaciones
                Técnicas, hasta el  {{$fechaInvitacion}}, en Oficinas de la Secretaria Regional de Economía y Finanzas
                 Publicas del G.A.R.G.CH, Adjuntado la siguiente documentación para su verificación y si
                 corresponde posterior adjudicación:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <b>Documentación Solicitada para la Adjudicación:</b>
            </td>
        </tr >
        <p>
        @forelse ($ordendoc as $key => $value)
        <tr >

            <td>{{$key+1 . '.- ' . $value -> nombredoc}}</td>

        </tr>
        @empty

        @endforelse
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >
                </p>
                <b>Nota.</b>
            </p>
                En caso de ser persona Natural deberá presentar los documentos solicitados en los incisos: 1,2,3,4 y 7.
        </p>
                    Sin otro particular saludo a Usted con atención.
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >
                Atte.
            </td>
        </tr>
        <tr>
            <td align="center">
                <br><br><br>
                {{$responsables->nombrerespcontrat}}<br><b>RESPONSABLE DEL PROCESO DE CONTRATACIÓN DE <br>APOYO NACIONAL A LA PRODUCCIÓN Y EMPLEO (RPA ANPE)</b>
            </td>
        </tr>
    </table>

</div>

