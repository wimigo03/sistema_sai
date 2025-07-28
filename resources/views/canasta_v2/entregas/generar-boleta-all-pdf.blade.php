<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html {
            margin: 20px 30px 15px 30px;
        }

        td, th {
            padding: 5px;
        }

        .container {
            position: relative;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
        }

        .watermark {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.3;
            z-index: -1;
        }

        .font-verdana-11 {font-size: 11px; font-family: verdana,arial,helvetica;}
        .font-verdana-10 {font-size: 10px; font-family: verdana,arial,helvetica;}
        .font-verdana-9 {font-size: 9px; font-family: verdana,arial,helvetica;}
        .font-verdana-8 {font-size: 8px; font-family: verdana,arial,helvetica;}
        .font-verdana-7 {font-size: 7px; font-family: verdana,arial,helvetica;}
        .text-justify {text-align: justify;}
        .align-center {text-align: center;}
        .align-middle {vertical-align: middle;}
        .align-superior {vertical-align: top;}
        .linea-superior {border-top: 1px solid #000;}
        .linea-inferior {border-bottom: 1px solid #000;}
        .linea-derecha {border-right: 1px solid #000;}
        .linea-izquierda {border-left: 1px solid #000;}
        .text-color-green {color: #198754;}

        .qr-boleta-pdf {
            width: 80px;
            height: auto;
            overflow: hidden;
            margin: 0;
            padding: 0;
            position: absolute;
            top: 65%;
            left: 62.5%;
            transform: translateX(-50%);
        }
    </style>
    <body>
        @php
            $cont = 0;
        @endphp
        @while ($cont < count($array_entrega))
            <div class="container">
                <table class="font-verdana-11" cellspacing="0" cellpadding="0" width="100%" style="width: 100%; padding: 0px; margin: 0;">
                    <img src="{{ ('logos/canastaalimentaria.jpeg') }}" class="watermark" alt="#"/>
                    <tr>
                        <td width="20%" class="align-center linea-superior linea-izquierda linea-inferior">
                            <img src="{{ ('logos/gobiernoregional.jpg') }}" width="90px" alt="#"/>
                        </td>
                        <td class="align-center align-middle linea-superior linea-inferior">
                            <b>
                                BOLETA DE ENTREGA Y CONFORMIDAD DE LA CANASTA ALIMENTARIA<br>
                                PROGRAMA INTEGRAL DE LAS PERSONAS DE LA TERCERA EDAD - YACUIBA
                            </b>
                        </td>
                        <td width="20%" class="align-center linea-superior linea-derecha linea-inferior">
                            <img src="{{ ('logos/mapa.png') }}" width="80px" alt="#"/>
                        </td>
                    </tr>
                </table>
                <table class="font-verdana-10" cellspacing="0" cellpadding="0" style="width: 100%; padding: 0px; margin: 0;">
                    <tr>
                        <td width="50%" class="align-center linea-izquierda linea-derecha linea-inferior">
                            <b><u>BARRIO / COMUNIDAD</u></b>
                            <br>
                            {{ $array_entrega[$cont]->barrio->nombre }}
                        </td>
                        <td rowspan="3" width="25%" class="align-center align-middle linea-derecha linea-inferior" style="padding: 2px;">
                            @php
                                $imageData = 'logos/d3.jpg';
                                if($array_entrega[$cont]->beneficiario->photo != null){
                                    //$imagePath = substr($array_entrega[$cont]->beneficiario->dir_foto, 3);
                                    $imagePath = 'imagenes/fotos-150px/' . $array_entrega[$cont]->beneficiario->photo;
                                    $imageData = '';
                                    if (file_exists($imagePath)) {
                                        $imageData = $imagePath;
                                    } else {
                                        $defaultImagePath = 'logos/d3.jpg';
                                        if (file_exists($defaultImagePath)) {
                                            $imageData = $defaultImagePath;
                                        }
                                    }
                                }
                            @endphp
                            <img src="{{ $imageData }}" width="80px" height="80px" alt="#" style="border-radius: 10%; overflow: hidden;"/>
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
                                ENTREGA DEL MES DE {{ $array_entrega[$cont]->paquete_barrio->periodos }} / {{ $array_entrega[$cont]->paquete->gestion }}
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
                                {{ $array_entrega[$cont]->paquete->items }}
                            </p>
                        </td>
                        <td class="align-center align-superior linea-derecha">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="linea-derecha align-superior font-verdana-8">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <b>C.I.: </b>{{ $array_entrega[$cont]->beneficiario->ci . ' ' . $array_entrega[$cont]->beneficiario->expedido }}
                            <br>
                            <b>Nombres: </b>{{ $array_entrega[$cont]->beneficiario->nombres . ' ' . $array_entrega[$cont]->beneficiario->ap . ' ' . $array_entrega[$cont]->beneficiario->am }}<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <b>Edad: </b>{{ \Carbon\Carbon::parse($array_entrega[$cont]->beneficiario->fecha_nac)->age }}<br>
                            &nbsp;
                            <b>Afilicion: </b>{{ \Carbon\Carbon::parse($array_entrega[$cont]->beneficiario->created_att)->format('d/m/Y') }}
                            @php
                                $entrega = App\Models\Canasta\Entrega::find($array_entrega[$cont]->id);
                                $contenido_qr = "CODIGO : " . (string) $entrega->id .
                                                "\nENTREGA DEL MES DE " . $entrega->paquete_barrio->periodos . " / " . $entrega->paquete->gestion .
                                                "\nB/C : " . $entrega->barrio->nombre .
                                                "\nBENEFICIARIO : " . $entrega->beneficiario->nombres . " " . $entrega->beneficiario->ap . " " . $entrega->beneficiario->am .
                                                "\nNRO. DE CARNET : " . $entrega->beneficiario->ci . " " . $entrega->beneficiario->expedido;
                                $contenido_qr = mb_convert_encoding($contenido_qr, "UTF-8", "auto");
                                $qrCode = base64_encode(QrCode::format('png')->margin(0)->size(200)->generate($contenido_qr));
                            @endphp
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
                            <br>
                        </td>
                        <td class="align-center linea-derecha font-verdana-7">
                            {{ Auth::user()->nombre_completo }}
                            <br>
                            <b>{{ Auth::user()->usuariosEmpleados->file_cargo }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="align-center linea-izquierda linea-inferior linea-derecha linea-superior font-verdana-9">
                            {{--<b class="text-color-green">Una Nueva Historia... Jose Luis Abrego Gobernador - Gestion {{ $array_entrega[$cont]->paquete->gestion }} RUMBO AL BICENTENARIO</b>--}}
                            <b class="text-color-green">Gestion {{ $array_entrega[$cont]->paquete->gestion }}</b>
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
