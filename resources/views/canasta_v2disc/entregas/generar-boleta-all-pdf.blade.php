<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    html {
        margin: 20px 30px 15px 30px;
    }

    body {
        margin: 0;
        padding: 0;
    }

    .table-100 {
        width: 100%;
        border-collapse: collapse;
    }

    .table-80 {
        width: 80%;
        border-collapse: collapse;
        border-top: 1px solid #000000;
        border-right: 1px solid #000000;
        border-bottom: 1px solid #000000;
        border-left: 1px solid #000000;
        margin-left: auto;
        margin-right: auto;
    }

    td,
    th {
        padding: 5px;
    }

    .align-center {
        text-align: center;
    }

    .align-right {
        text-align: right;
    }

    .align-inferior {
        vertical-align: bottom;
    }

    .align-middle {
        vertical-align: middle;
    }

    .align-superior {
        vertical-align: top;
    }

    .linea-superior {
        border-top: 1px solid #000;
    }

    .linea-inferior {
        border-bottom: 1px solid #000;
    }

    .linea-derecha {
        border-right: 1px solid #000;
    }

    .linea-izquierda {
        border-left: 1px solid #000;
    }

    .linea-superior-gris {
        border-top: 1px solid #ccc;
    }

    .linea-inferior-gris {
        border-bottom: 1px solid #ccc;
    }

    .linea-derecha-gris {
        border-right: 1px solid #ccc;
    }

    .linea-izquierda-gris {
        border-left: 1px solid #ccc;
    }

    .sub-linea-inferior {
        border-bottom: 1px solid #ccc;
    }

    .page_break {
        page-break-before: always;
    }

    .logo-canasta-alimentaria {
        width: 60px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .logo-canasta-alimentaria-sm {
        width: 20px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .logo-gran-chaco {
        width: 140px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .logo-gran-chaco-sm {
        width: 90px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .logo-nueva-historia {
        width: 100px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .logo-nueva-historia-sm {
        width: 80px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .foto-boleta-pdf {
        width: 80px;
        height: 80px;
        border-radius: 10%;
        overflow: hidden;
    }

    .qr-boleta-pdf {
        width: 80px;
        height: auto;
        overflow: hidden;
        margin: 0;
        padding: 0;
        position: absolute;
        top: 70%;
        left: 62.5%;
        transform: translateX(-50%);
    }

    .foto-pdf-show {
        width: 150px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .icono-check {
        width: 10px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .icono-uncheck {
        width: 10px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .bg-gradient-warning {
        background-color: #f6c23e;
        background-image: linear-gradient(180deg, #f6c23e 10%, #dda20a 100%);
        background-size: cover;
        color: #ffffff;
    }

    .bg-gradient-secondary {
        background-color: #6c757d;
        background-image: linear-gradient(180deg, #6c757d 10%, #807e7e 100%);
        background-size: cover;
        color: #ffffff;
    }

    .bg-color-green {
        background-color: #e9e6C5;
    }

    .text-color-green {
        color: #198754;
    }

    /*Verdana*/
    .font-verdana-5 {
        font-size: 5px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-6 {
        font-size: 6px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-7 {
        font-size: 7px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-8 {
        font-size: 8px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-9 {
        font-size: 9px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-10 {
        font-size: 10px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-11 {
        font-size: 11px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-12 {
        font-size: 12px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-13 {
        font-size: 13px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-14 {
        font-size: 14px;
        font-family: verdana, arial, helvetica;
    }

    .font-verdana-15 {
        font-size: 15px;
        font-family: verdana, arial, helvetica;
    }

    .text-justify {
        text-align: justify;
    }

    #img-beneficiario {
        width: 200px;
        height: auto;
        overflow: hidden;
        border: 1px solid #000;
    }

    .img-beneficiario-pdf {
        width: 25px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }

    .container {
        position: relative;
        width: 100%;
        height: auto;
        background-color: #ffffff;
        border: 1px solid #000000;
        /* borde externo fijo */
        box-sizing: border-box;
        /* evita que el borde saque el contenido */
        padding: 4px;
        /* espacio entre borde externo y cuadros internos */
        margin: 0 0 6px 0;
        /* separa una boleta de la otra */
    }

    .watermark {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.3;
        z-index: -1;
    }

    .page-break {
        page-break-after: always;
    }
</style>

<body>
    @php
        $cont = 0;
    @endphp
    @while ($cont < count($array_entrega))
        <div class="container">
            {{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/canastaalimentaria.jpeg'))) }}" class="watermark" alt="#"/> --}}
            <table class="font-verdana-11" cellspacing="0" cellpadding="0" width="100%"
                style="width: 100%; padding: 0px; margin: 0;">
                <tr>
                    <td width="20%" class="align-center linea-superior linea-izquierda linea-inferior">
                        {{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/gobiernoregional.jpg'))) }}" class="logo-gran-chaco-sm" alt="#"/> --}}
                        <img src="{{ 'logos/gobiernoregional.jpg' }}" class="logo-gran-chaco-sm" alt="#" />
                    </td>
                    <td class="align-center align-middle linea-superior linea-inferior">
                        <b>
                            BOLETA DE ENTREGA Y CONFORMIDAD DEL PAQUETE ALIMENTARIO DEL<br>
                            PROGRAMA DE ASISTENCIA INTEGRAL A LAS PERSONAS CON DISCAPACIDAD
                            YACUIBA - GRAN CHACO
                        </b>
                    </td>
                    <td width="20%" class="align-center linea-superior linea-derecha linea-inferior">
                        {{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/mapa.png'))) }}" class="logo-nueva-historia-sm" alt="#"/> --}}
                        <img src="{{ 'logos/mapa.png' }}" class="logo-nueva-historia-sm" alt="#" />
                    </td>
                </tr>
            </table>
            <table class="font-verdana-10" cellspacing="0" cellpadding="0"
                style="width: 100%; padding: 0px; margin: 0;">
                <tr>
                    <td width="50%" class="align-center linea-izquierda linea-derecha linea-inferior">
                        <b><u>BARRIO / COMUNIDAD</u></b>
                        <br>
                        {{ $array_entrega[$cont]->barrio->nombre }}
                    </td>
                    <td rowspan="3" width="25%" class="align-center align-middle linea-derecha linea-inferior"
                        style="padding: 2px;">
                        @php
                            $imagePath = substr($array_entrega[$cont]->beneficiario->dir_foto, 3);
                            $imageData = '';
                            if (file_exists($imagePath)) {
                                $imageData = $imagePath;
                            } else {
                                $defaultImagePath = 'logos/d3.jpg';
                                if (file_exists($defaultImagePath)) {
                                    $imageData = $defaultImagePath;
                                }
                            }
                        @endphp
                        <img src="{{ $imageData }}" class="foto-boleta-pdf" alt="#"
                            style="width:120px;height:120px;" />
                    </td>
                    <td class="align-center align-superior linea-derecha">
                        <b>Firma en conformidad</b>
                        <br>
                        ¿Beneficiario firma? ({{ $array_entrega[$cont]->beneficiario->firma }})
                    </td>
                </tr>
                <tr>
                    <td class="align-center linea-izquierda linea-derecha">
                        <p>
                            ENTREGA DEL MES DE {{ $array_entrega[$cont]->paquete_barrio->periodos }} /
                            {{ $array_entrega[$cont]->paquete->gestion }}
                            <!-- ENTREGA DE PAQUETE ALIMENTARIO CORRESPONDIENTE A LA  <br> 8VA – 9NA – 10MA ENTREGA -->
                        </p>
                    </td>
                    <td class="align-center align-superior linea-derecha">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td rowspan="4" class="align-center linea-izquierda linea-derecha linea-superior linea-inferior">
                        <b><u>PRODUCTOS POR PAQUETE ALIMENTARIO</u></b>
                        <p class="text-justify" style="font-size: 10">
                            {{ $array_entrega[$cont]->paquete->items }}
                        </p>
                    </td>
                    <td class="align-center align-inferior linea-derecha linea-inferior">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" class="linea-derecha align-superior font-verdana-10">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>C.I.:
                        </b>{{ $array_entrega[$cont]->beneficiario->ci . ' ' . $array_entrega[$cont]->beneficiario->expedido }}
                        <br><br>
                        <b>Nombres:
                        </b>{{ $array_entrega[$cont]->beneficiario->nombres . ' ' . $array_entrega[$cont]->beneficiario->ap . ' ' . $array_entrega[$cont]->beneficiario->am }}<br>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>Edad:
                        </b>{{ \Carbon\Carbon::parse($array_entrega[$cont]->beneficiario->fecha_nac)->age }}<br>
                        &nbsp;
                        <b>Afilicion:
                        </b>{{ \Carbon\Carbon::parse($array_entrega[$cont]->beneficiario->created_att)->format('d/m/Y') }}
                        <br>

                        <b>Discapacidad: </b>{{ $array_entrega[$cont]->Discgrado }} <br>
                        @php
                            $entrega = App\Models\Canasta\Entrega::find($array_entrega[$cont]->id);
                            $contenido_qr =
                                'CODIGO : ' .
                                (string) $entrega->id .
                                "\nENTREGA DEL MES DE " .
                                $entrega->paquete_barrio->periodos .
                                ' / ' .
                                $entrega->paquete->gestion .
                                "\nB/C : " .
                                $entrega->barrio->nombre .
                                "\nBENEFICIARIO : " .
                                $entrega->beneficiario->nombres .
                                ' ' .
                                $entrega->beneficiario->ap .
                                ' ' .
                                $entrega->beneficiario->am .
                                "\nNRO. DE CARNET : " .
                                $entrega->beneficiario->ci .
                                ' ' .
                                $entrega->beneficiario->expedido;
                            $contenido_qr = mb_convert_encoding($contenido_qr, 'UTF-8', 'auto');
                            $qrCode = base64_encode(
                                QrCode::format('png')->margin(0)->size(200)->generate($contenido_qr),
                            );
                        @endphp
                        <br>
                        <img src="data:image/png;base64, {{ $qrCode }}" class="qr-boleta-pdf" alt="Código QR">
                    </td>
                    <td class="align-center linea-derecha">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="align-center align-inferior linea-derecha linea-inferior font-verdana-9">
                        {{ $array_entrega[$cont]->beneficiario->tutor }}<br>{{ $array_entrega[$cont]->beneficiario->parentesco }}
                    </td>
                </tr>
                <tr>
                    <td class="align-center linea-derecha">
                        &nbsp;
                    </td>
                    <td class="align-center linea-derecha">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="align-center linea-izquierda linea-derecha">
                        Fecha de impresion: {{ \Carbon\Carbon::now()->translatedFormat('F \\d\\e Y') }}
                    </td>
                    <td class="align-center linea-derecha">
                        <br>
                        <br>
                        <br>
                    </td>
                    <td class="align-center linea-derecha font-verdana-7">
                        {{ Auth::user()->nombre_completo }}
                        <br>
                        <b>RESPONSABLE DEL PROGRAMA DE ASISTENCIA INTEGRAL DE LAS PERSONAS CON DISCAPACIDAD Y DEL ADULTO
                            MAYOR a.i.</b>
                        {{-- <b>{{ Auth::user()->usuariosEmpleados->file_cargo }}</b> --}}
                    </td>
                </tr>
                <tr>
                    <td colspan="3"
                        class="align-center linea-izquierda linea-inferior linea-derecha linea-superior font-verdana-9"">
                        <b class="text-color-green">Una Nueva Historia... Jose Luis Abrego Gobernador - Gestion
                            {{ $array_entrega[$cont]->paquete->gestion }} RUMBO AL BICENTENARIO</b>
                    </td>
                </tr>
            </table>
        </div>


        <div class="container">
            {{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/canastaalimentaria.jpeg'))) }}" class="watermark" alt="#"/> --}}
            <table class="font-verdana-11" cellspacing="0" cellpadding="0" width="100%"
                style="width: 100%; padding: 0px; margin: 0;">
                <tr>
                    <td width="20%" class="align-center linea-superior linea-izquierda linea-inferior">
                        {{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/gobiernoregional.jpg'))) }}" class="logo-gran-chaco-sm" alt="#"/> --}}
                        <img src="{{ 'logos/gobiernoregional.jpg' }}" class="logo-gran-chaco-sm" alt="#" />
                    </td>
                    <td class="align-center align-middle linea-superior linea-inferior">
                        <b>
                            BOLETA DE ENTREGA Y CONFORMIDAD DEL PAQUETE ALIMENTARIO DEL<br>
                            PROGRAMA DE ASISTENCIA INTEGRAL A LAS PERSONAS CON DISCAPACIDAD
                            YACUIBA - GRAN CHACO
                        </b>
                    </td>
                    <td width="20%" class="align-center linea-superior linea-derecha linea-inferior">
                        {{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/mapa.png'))) }}" class="logo-nueva-historia-sm" alt="#"/> --}}
                        <img src="{{ 'logos/mapa.png' }}" class="logo-nueva-historia-sm" alt="#" />
                    </td>
                </tr>
            </table>
            <table class="font-verdana-10" cellspacing="0" cellpadding="0"
                style="width: 100%; padding: 0px; margin: 0;">
                <tr>
                    <td width="50%" class="align-center linea-izquierda linea-derecha linea-inferior">
                        <b><u>BARRIO / COMUNIDAD</u></b>
                        <br>
                        {{ $array_entrega[$cont]->barrio->nombre }}
                    </td>
                    <td rowspan="3" width="25%" class="align-center align-middle linea-derecha linea-inferior"
                        style="padding: 2px;">
                        @php
                            $imagePath = substr($array_entrega[$cont]->beneficiario->dir_foto, 3);
                            $imageData = '';
                            if (file_exists($imagePath)) {
                                $imageData = $imagePath;
                            } else {
                                $defaultImagePath = 'logos/d3.jpg';
                                if (file_exists($defaultImagePath)) {
                                    $imageData = $defaultImagePath;
                                }
                            }
                        @endphp
                        <img src="{{ $imageData }}" class="foto-boleta-pdf" alt="#"
                            style="width:120px;height:120px;" />
                    </td>
                    <td class="align-center align-superior linea-derecha">
                        <b>Firma en conformidad</b>
                        <br>
                        ¿Beneficiario firma? ({{ $array_entrega[$cont]->beneficiario->firma }})
                    </td>
                </tr>
                <tr>
                    <td class="align-center linea-izquierda linea-derecha">
                        <p>
                            ENTREGA DEL MES DE {{ $array_entrega[$cont]->paquete_barrio->periodos }} /
                            {{ $array_entrega[$cont]->paquete->gestion }}
                            <!-- ENTREGA DE PAQUETE ALIMENTARIO CORRESPONDIENTE A LA  <br>8VA – 9NA – 10MA ENTREGA -->
                        </p>
                    </td>
                    <td class="align-center align-superior linea-derecha">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td rowspan="4" class="align-center linea-izquierda linea-derecha linea-superior linea-inferior">
                        <b><u>PRODUCTOS POR PAQUETE ALIMENTARIO</u></b>
                        <p class="text-justify" style="font-size: 10">
                            {{ $array_entrega[$cont]->paquete->items }}
                        </p>
                    </td>
                    <td class="align-center align-inferior linea-derecha linea-inferior">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" class="linea-derecha align-superior font-verdana-10">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>C.I.:
                        </b>{{ $array_entrega[$cont]->beneficiario->ci . ' ' . $array_entrega[$cont]->beneficiario->expedido }}
                        <br><br>
                        <b>Nombres:
                        </b>{{ $array_entrega[$cont]->beneficiario->nombres . ' ' . $array_entrega[$cont]->beneficiario->ap . ' ' . $array_entrega[$cont]->beneficiario->am }}<br>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>Edad:
                        </b>{{ \Carbon\Carbon::parse($array_entrega[$cont]->beneficiario->fecha_nac)->age }}<br>
                        &nbsp;
                        <b>Afilicion:
                        </b>{{ \Carbon\Carbon::parse($array_entrega[$cont]->beneficiario->created_att)->format('d/m/Y') }}
                        <br>

                        <b>Discapacidad: </b>{{ $array_entrega[$cont]->Discgrado }} <br>
                        @php
                            $entrega = App\Models\Canasta\Entrega::find($array_entrega[$cont]->id);
                            $contenido_qr =
                                'CODIGO : ' .
                                (string) $entrega->id .
                                "\nENTREGA DEL MES DE " .
                                $entrega->paquete_barrio->periodos .
                                ' / ' .
                                $entrega->paquete->gestion .
                                "\nB/C : " .
                                $entrega->barrio->nombre .
                                "\nBENEFICIARIO : " .
                                $entrega->beneficiario->nombres .
                                ' ' .
                                $entrega->beneficiario->ap .
                                ' ' .
                                $entrega->beneficiario->am .
                                "\nNRO. DE CARNET : " .
                                $entrega->beneficiario->ci .
                                ' ' .
                                $entrega->beneficiario->expedido;
                            $contenido_qr = mb_convert_encoding($contenido_qr, 'UTF-8', 'auto');
                            $qrCode = base64_encode(
                                QrCode::format('png')->margin(0)->size(200)->generate($contenido_qr),
                            );
                        @endphp
                        <br>
                        <img src="data:image/png;base64, {{ $qrCode }}" class="qr-boleta-pdf" alt="Código QR">
                    </td>
                    <td class="align-center linea-derecha">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="align-center align-inferior linea-derecha linea-inferior font-verdana-9">
                        {{ $array_entrega[$cont]->beneficiario->tutor }}<br>{{ $array_entrega[$cont]->beneficiario->parentesco }}
                    </td>
                </tr>
                <tr>
                    <td class="align-center linea-derecha">
                        &nbsp;
                    </td>
                    <td class="align-center linea-derecha">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="align-center linea-izquierda linea-derecha">
                        Fecha de impresion: {{ \Carbon\Carbon::now()->translatedFormat('F \\d\\e Y') }}
                    </td>
                    <td class="align-center linea-derecha">
                        <br>
                        <br>
                    </td>
                    <td class="align-center linea-derecha font-verdana-7">
                        {{ Auth::user()->nombre_completo }}
                        <br>
                        <b>{{ Auth::user()->usuariosEmpleados->file_cargo }}</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"
                        class="align-center linea-izquierda linea-inferior linea-derecha linea-superior font-verdana-9"">
                        <b class="text-color-green">Una Nueva Historia... Jose Luis Abrego Gobernador - Gestion
                            {{ $array_entrega[$cont]->paquete->gestion }} RUMBO AL BICENTENARIO</b>
                    </td>
                </tr>
            </table>
        </div>
        @php
            $cont++;
        @endphp
    @endwhile
</body>

</html>
