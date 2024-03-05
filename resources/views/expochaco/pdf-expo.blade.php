<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div class="page-header" align="center">
        <img src="{{ asset('logos/header-expo.jpg') }}" width="700px" height="70px" />
    </div>
    <p>
        Solicitamos nuestra inscripci&oacute;n para participar en la EXPOCHACO SUDAMERICANO 2023, en
        conformidad con las condiciones estipuladas en el Manual de Expositor, el que declaramos conocer,
        aceptar y dar cumplimiento as&iacute; como a las dem&aacute;s disposiciones emitidas por los
        organizadores del evento.
    <p>
    <table border="1" cellspacing="0" cellpadding="0" width="100%"
        style="font-size: 14px; border: 1px solid black;border-collapse: collapse;">
        <tbody>

            <tr>
                <td colspan="3" width="42%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;NOMBRE Y APELLIDO DEL SOLICITANTE&nbsp;</strong>
                </td>
                <td colspan="2" width="29%" style="background-color: rgb(201, 237, 240);">
                    <strong>ASOCIACI&Oacute;N</strong>
                </td>
                <td colspan="2" width="28%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;C.I. N°.&nbsp;</strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" width="42%">
                    &nbsp;{{$solicitud->nombresolicitud}}
                </td>
                <td colspan="2" width="29%">
                    &nbsp;{{$solicitud->asociacionsol}}

                </td>
                <td colspan="2" width="28%">
                    &nbsp;{{$solicitud->ci}}
                </td>
            </tr>
            <tr>
                <td colspan="3" width="42%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;DIRECCI&Oacute;N</strong>
                </td>
                <td colspan="4" width="57%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;DISTRITO/CIUDAD</strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" width="42%">
                    &nbsp;{{$solicitud->direccionsol}}
                </td>
                <td colspan="4" width="57%">
                    &nbsp;{{$solicitud->ciudad}}
                </td>
            </tr>
            <tr>
                <td colspan="3" width="42%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;TEL&Eacute;FONO </strong><strong>/Cel.</strong>
                </td>
                <td colspan="4" width="57%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;E-MAIL</strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" width="42%">
                    &nbsp;{{$solicitud->telefonosol}}
                </td>
                <td colspan="4" width="57%">
                    &nbsp;{{$solicitud->correosol}}
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;RUBRO:</strong>
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;NOMBRE DEL GERENTE - PRESIDENTE -REPRESENTANTE LEGAL ASOCIACI&Oacute;N O
                        INSTITUCI&Oacute;N</strong>
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%">
                    &nbsp;{{$solicitud->representante}} &nbsp; <strong>Ci:&nbsp;</strong>{{$solicitud->cirepresentante}}
                </td>
            </tr>

            <tr>
                <td colspan="7" width="100%">
                    <strong>&nbsp;Solicitamos la descripci&oacute;n de los siguientes espacios:</strong>
                </td>
            </tr>
            <tr>
                <td rowspan="2" width="25%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;PABELL&Oacute;N / &Aacute;REA</strong>
                </td>
                <td rowspan="2" width="15%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;N&ordm; DE STAND</strong>
                </td>
                <td colspan="2" width="23%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;SUPERFICIE</strong>
                </td>
                <td colspan="2" width="14%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;PRECIO</strong>
                </td>
                <td width="20%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;PRECIO STAND</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2" width="23%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;(m<sup>2</sup>)</strong>
                </td>
                <td colspan="2" width="14%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;Bs/(m<sup>2</sup>)</strong>
                </td>
                <td width="20%" style="background-color: rgb(201, 237, 240);">
                    <strong>&nbsp;(Bs) </strong>
                </td>
            </tr>
            <tr>
                <td width="25%">
                    &nbsp;{{$solicitud->pabellon}}
                </td>
                <td width="15%">
                    &nbsp;{{$solicitud->nstand}}
                </td>
                <td colspan="2" width="23%">
                    &nbsp;{{$solicitud->superficie}}
                </td>
                <td colspan="2" width="14%">
                    &nbsp;{{$solicitud->precio}}
                </td>
                <td width="20%">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="6" width="79%" align="right">
                    <strong>TOTAL BS.-&nbsp;</strong>
                </td>
                <td width="20%">
                    &nbsp;{{$solicitud->total}}
                </td>
            </tr>
            <tr>
                <td colspan="3" width="42%" style="background-color: rgb(201, 237, 240);">
                    &nbsp;<strong>RECIBO&nbsp; A NOMBRE DE:</strong>
                </td>
                <td colspan="3" width="37%" style="background-color: rgb(201, 237, 240);">
                    &nbsp;<strong>C.I. No.</strong>
                </td>
                <td width="20%">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" width="42%">
                    &nbsp;{{$solicitud->recibonombre}}
                </td>
                <td colspan="3" width="37%">
                    &nbsp;{{$solicitud->reciboci}}
                </td>
                <td width="20%">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%" style="background-color: rgb(201, 237, 240);">
                &nbsp;En las zonas designadas expondremos los siguientes productos y/o servicios:
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%" >
                    <strong>&nbsp;</strong>
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%" >
                    <strong>&nbsp;</strong>
                </td>
            </tr>

            <tr>
                <td colspan="7" width="100%">
                    <strong>&nbsp;</strong>
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%">
                    <strong>&nbsp;</strong>
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%">
                    <strong>&nbsp;</strong>
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%">
                    <strong>&nbsp;</strong>
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%">
                    <strong>&nbsp;</strong>
                </td>
            </tr>
            <tr>
                <td colspan="7" width="100%">
                    <strong>&nbsp;</strong>
                </td>
            </tr>
        </tbody>
    </table>
<p><p><p><p><p><p>
    FIRMA RESP. EXPOCHACO G.A.R.G.CH.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FIRMA DEL EXPOSITOR

        <p><p><p><p><p><p>

        V° B° ASOCIACIÓN /INSTITUCIÓN



</body>

</html>
