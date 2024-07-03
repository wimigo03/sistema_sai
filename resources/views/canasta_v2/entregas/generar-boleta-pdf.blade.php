<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        <?php echo file_get_contents(public_path('css/font-verdana-pdf.css')); ?>
        html {
            margin: 20px 30px 15px 30px;
        }
    </style>
    <body>
        <div class="container">
            {{--<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/canastaalimentaria.jpeg'))) }}" class="watermark" alt="#"/>--}}
            <img src="{{ ('logos/canastaalimentaria.jpeg') }}" class="watermark" alt="#"/>
            <table class="font-verdana-11" cellspacing="0" cellpadding="0" width="100%" style="width: 100%; padding: 0px; margin: 0;">
                <tr>
                    <td width="20%" class="align-center linea-superior linea-izquierda linea-inferior">
                        {{--<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/gobiernoregional.jpg'))) }}" class="logo-gran-chaco-sm" alt="#"/>--}}
                        <img src="{{ ('logos/gobiernoregional.jpg') }}" class="logo-gran-chaco-sm" alt="#"/>
                    </td>
                    <td class="align-center align-middle linea-superior linea-inferior">
                        <b>
                            BOLETA DE ENTREGA Y CONFORMIDAD DE LA CANASTA ALIMENTARIA<br>
                            PROGRAMA INTEGRAL DE LAS PERSONAS DE LA TERCERA EDAD - YACUIBA
                        </b>
                    </td>
                    <td width="20%" class="align-center linea-superior linea-derecha linea-inferior">
                        {{--<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/mapa.png'))) }}" class="logo-nueva-historia-sm" alt="#"/>--}}
                        <img src="{{ ('logos/mapa.png') }}" class="logo-nueva-historia-sm" alt="#"/>
                    </td>
                </tr>
            </table>
            <table class="font-verdana-10" cellspacing="0" cellpadding="0" style="width: 100%; padding: 0px; margin: 0;">
                <tr>
                    <td width="50%" class="align-center linea-izquierda linea-derecha linea-inferior">
                        <b><u>BARRIO / COMUNIDAD</u></b>
                        <br>
                        {{ $entrega->barrio->nombre }}
                    </td>
                    <td rowspan="3" width="25%" class="align-center align-middle linea-derecha linea-inferior" style="padding: 2px;">
                        @php
                            $imagePath = substr($entrega->beneficiario->dir_foto, 3);
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
                        <img src="{{ $imageData }}" class="foto-boleta-pdf" alt="#"/>
                    </td>
                    <td class="align-center align-superior linea-derecha">
                        <b>Firma en conformidad</b>
                        <br>
                        ¿Beneficiario firma? ({{ $entrega->beneficiario->firma }})
                    </td>
                </tr>
                <tr>
                    <td class="align-center linea-izquierda linea-derecha">
                        <p>
                            ENTREGA DEL MES DE {{ $entrega->paquete_barrio->periodos }} / {{ $entrega->paquete->gestion }}
                        </p>
                    </td>
                    <td class="align-center align-superior linea-derecha">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td rowspan="4" class="align-center linea-izquierda linea-derecha linea-superior linea-inferior">
                        <b><u>PRODUCTOS POR CANASTA ALIMENTARIA</u></b>
                        <p class="text-justify">
                            {{ $entrega->paquete->items }}
                        </p>
                    </td>
                    <td class="align-center align-superior linea-derecha">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" class="linea-derecha align-superior font-verdana-8">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>C.I.: </b>{{ $entrega->beneficiario->ci . ' ' . $entrega->beneficiario->expedido }}
                        <br>
                        <b>Nombres: </b>{{ $entrega->beneficiario->nombres . ' ' . $entrega->beneficiario->ap . ' ' . $entrega->beneficiario->am }}<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>Edad: </b>{{ \Carbon\Carbon::parse($entrega->beneficiario->fecha_nac)->age }}<br>
                        &nbsp;
                        <b>Afilicion: </b>{{ \Carbon\Carbon::parse($entrega->beneficiario->created_att)->format('d/m/Y') }}
                        <br>
                        <img src="data:image/png;base64, {{ $qrCode }}" class="qr-boleta-pdf" alt="Código QR" >
                    </td>
                    <td class="align-center linea-derecha linea-inferior">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="align-center linea-derecha">
                        &nbsp;
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
                    <td class="align-center linea-derecha font-verdana-8">
                        {{ Auth::user()->nombre_completo }}
                        <br>
                        <b>{{ Auth::user()->usuariosEmpleados->file_cargo }}</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="align-center linea-izquierda linea-inferior linea-derecha linea-superior">
                        <b class="text-color-green">Una Nueva Historia... Jose Luis Abrego Gobernador - Gestion {{ $entrega->paquete->gestion }} RUMBO AL BICENTENARIO</b>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
