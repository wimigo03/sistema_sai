<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta name="generator" content="Aspose.Words for .NET 23.12.0" />
    <title></title>
    <link href="{{ asset('tablas.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        body {
            line-height: 108%;
            font-family: Calibri;
            font-size: 11pt
        }

        p {
            margin: 0pt 0pt 8pt
        }

        table {
            margin-top: 0pt;
            margin-bottom: 8pt
        }

        .page-break {
            page-break-after: always;
        }

        .BalloonText {
            margin-bottom: 0pt;
            line-height: normal;
            font-family: 'Segoe UI';
            font-size: 9pt
        }

        .NoSpacing {
            margin-bottom: 0pt;
            line-height: normal;
            font-size: 11pt
        }

        span.TextodegloboCar {
            font-family: 'Segoe UI';
            font-size: 9pt
        }

        .TableGrid {}

        @page {
            size: 9.5cm 19.2cm landscape;
            margin: 10px;
        }
    </style>
</head>

<body>
    <div>
        @forelse ($entregas as $entrega)
            <table width="900" align="center" HEIGHT="410" class="tabla1 fondo_tabla">
                <tr>

                    <td colspan="3" class="td1">

                        <table width="100%" align="center" HEIGHT="100%">

                            <tr>
                                <td width="20%" align="center">
                                    <img src="{{ asset('logos/gobiernoregional.jpg') }}" width="120"
                                        HEIGHT="60" />

                                </td>
                                <td align="center">
                                    <b>
                                        BOLETA DE ENTREGA Y CONFORMIDAD DE LA CANASTA ALIMENTARIA
                                        <br>
                                        PROGRAMA INTEGRAL DE LAS PERSONAS DE LA TERCERA EDAD - YACUIBA
                                    </b>


                                </td>
                                <td width="20%" align="center">
                                    <img src="{{ asset('logos/mapa.jpg') }}" width="120" HEIGHT="60" />

                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <!-- FORMULARIO  DEL CENTRO -->
                <tr vAlign="top">
                    <td width="53%">
                        <table width="100%" height="320" class="tabla1">
                            <tr width="100%">
                                <td>
                                    <center><b>BARRIO/COMUNIDAD</b></center>
                                </td>
                            </TR>
                            <tr>
                                <td class="td1">
                                    <center>
                                        {{ $entrega->barrio->nombre }}
                                    </center>
                                </td>

                            </TR>
                            <tr>
                                <td>
                                    <center><b>ENTREGA DEL MES</b></center>
                                </td>

                            </tr>
                            <tr>
                                <td class="td1">
                                    <center>
                                        {{ $entrega->paquete->periodo }} - {{ $entrega->paquete->gestion }}
                                    </center>
                                </td>

                            </tr>

                            <tr>
                                <td class="td1">
                                    <div align="justify"> <b>Productos por Canasta Alimentaria:</b>&nbsp;
                                        {{ $entrega->paquete->items }}
                                    </div>
                                </td>
                            </tr>
                            <tr>

                                <td class="td2"><b>Fecha de Impresion:</b>&nbsp;&nbsp;{{ $fecha_actual }}</td>
                            </tr>
                        </table>

                    </td>
                    <td width="25%" vAlign="top">
                        <table width="100%" height="320" class="tabla1">
                            <tr height="150">
                                <td colspan="2">
                                    <center><img src="{{ $entrega->beneficiario->dirFoto }}" width='120'
                                            height='120' />
                                    </center>
                                </td>
                            </TR>
                            <tr>
                                <td class="td1"><b>C.I.:</b></td>
                                <td class="td2">
                                    {{ $entrega->beneficiario->ci }}
                                </td>

                            </TR>
                            <tr>
                                <td class="td1"><b>Nombres:</b></td>
                                <td class="td2">
                                    {{ $entrega->beneficiario->nombres }} {{ $entrega->beneficiario->ap }}
                                {{ $entrega->beneficiario->am }}
                                </td>

                            </tr>
                            <tr>
                                <td class="td1"><b>Edad:</b></td>
                                <td class="td2">
                                    {{ $entrega->beneficiario->age() }}
                                </td>

                            </tr>
                            <tr>
                                <td class="td1"><b>Fecha de Afiliación:</b></td>
                                <td class="td2">
                                    {{ \Carbon\Carbon::parse($entrega->beneficiario->created_att)->format('d/m/Y') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="22%" vAlign="top">
                        <table width="100%" class="tabla1">
                            <tr>
                                <td>
                                    <strong>
                                        Firma en Conformidad
                                    </strong>
                                </td>
                            </tr>
                            <tr height="164" vAlign="top">
                                <td class="td1" style="text-align: center;">Beneficiario: Firma&nbsp;&nbsp;
                                    <strong>
                                        {{ $entrega->beneficiario->firma }}
                                    </strong>
                                </td>

                            </tr>
                            <tr height="130" vAlign="top">
                                <td class="td1">
                                    <div style="font-size: 12px; text-align: center;">
                                        <br><br><br><br><br><br>
                                        {{ $userdate->nombres }} {{ $userdate->ap_pat }} {{ $userdate->ap_mat }}
                                        <br>
                                        <strong>
                                            {{ $userdate->file->nombrecargo }}
                                        </strong>
                                    </div>
                                </td>
                            </tr>
                        </table>


                    </td>
                </tr>
                <!-- FORMULARIO  DEL CENTRO -->
                <tr>
                    <td colspan="3" class="td1">
                        <div align="center">
                            <strong>
                                UNA NUEVA HISTORIA...JOSÉ LUIS ABREGO GOBERNADOR - <em style="color: #00a139;">RUMBO AL BICENTENARIO</em>
                            </strong>
                        </div>
                    </td>

                </tr>
            </table>
            <div class="page-break"></div>
        @endforeach
    </div>

</body>

</html>
