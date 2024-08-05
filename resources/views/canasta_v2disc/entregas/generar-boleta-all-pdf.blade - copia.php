<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        <?php echo file_get_contents(public_path('css/font-verdana-pdf.css')); ?>
        html {
            margin: 25px 30px 25px 30px;
        }
    </style>
    <body>
        @php
            $cont = 0;
        @endphp
        @while ($cont < count($array_entrega))
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
                            {{ $array_entrega[$cont]->barrio->nombre }}
                        </td>
                        <td rowspan="3" width="25%" class="align-center align-middle linea-derecha linea-inferior" style="padding: 2px;">
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
                            <img src="{{ $imageData }}" class="foto-boleta-pdf" alt="#"/>
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
                            Fecha de impresion: {{ \Carbon\Carbon::now()->translatedFormat('d \\d\\e F \\d\\e Y H:i:s') }}
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
                        <td colspan="3" class="align-center linea-izquierda linea-inferior linea-derecha linea-superior font-verdana-9"">
                            <b class="text-color-green">Una Nueva Historia... Jose Luis Abrego Gobernador - Gestion {{ $array_entrega[$cont]->paquete->gestion }} RUMBO AL BICENTENARIO</b>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <br>
            @php
                $cont++;
            @endphp
            @if (isset($array_entrega[$cont]))
                <div class="container">
                    <img src="{{ ('logos/canastaalimentaria.jpeg') }}" class="watermark" alt="#"/>
                    <table class="font-verdana-11" cellspacing="0" cellpadding="0" width="100%" style="width: 100%; padding: 0px; margin: 0;">
                        <tr>
                            <td width="20%" class="align-center linea-superior linea-izquierda linea-inferior">
                                <img src="{{ ('logos/gobiernoregional.jpg') }}" class="logo-gran-chaco-sm" alt="#"/>
                            </td>
                            <td class="align-center align-middle linea-superior linea-inferior">
                                <b>
                                    BOLETA DE ENTREGA Y CONFORMIDAD DE LA CANASTA ALIMENTARIA<br>
                                    PROGRAMA INTEGRAL DE LAS PERSONAS DE LA TERCERA EDAD - YACUIBA
                                </b>
                            </td>
                            <td width="20%" class="align-center linea-superior linea-derecha linea-inferior">
                                <img src="{{ ('logos/mapa.png') }}" class="logo-nueva-historia-sm" alt="#"/>
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
                                    $imagePath = substr($array_entrega[$cont]->beneficiario->dir_foto, 3);
                                    $imageData = '';
                                    if (file_exists($imagePath)) {
                                        $imageData = base64_encode(file_get_contents($imagePath));
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
                            <td rowspan="2" class="linea-derecha align-superior font-verdana-9">
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
                                Fecha de impresion: {{ \Carbon\Carbon::now()->translatedFormat('d \\d\\e F \\d\\e Y H:i:s') }}
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
                            <td colspan="3" class="align-center linea-izquierda linea-inferior linea-derecha linea-superior font-verdana-9">
                                <b class="text-color-green">Una Nueva Historia... Jose Luis Abrego Gobernador - Gestion {{ $array_entrega[$cont]->paquete->gestion }} RUMBO AL BICENTENARIO</b>
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
                <br>
            @endif
            @php
                $cont++;
            @endphp
            @if (isset($array_entrega[$cont]))
                <div class="container">
                    <img src="{{ ('logos/canastaalimentaria.jpeg') }}" class="watermark" alt="#"/>
                    <table class="font-verdana-11" cellspacing="0" cellpadding="0" width="100%" style="width: 100%; padding: 0px; margin: 0;">
                        <tr>
                            <td width="20%" class="align-center linea-superior linea-izquierda linea-inferior">
                                <img src="{{ ('logos/gobiernoregional.jpg') }}" class="logo-gran-chaco-sm" alt="#"/>
                            </td>
                            <td class="align-center align-middle linea-superior linea-inferior">
                                <b>
                                    BOLETA DE ENTREGA Y CONFORMIDAD DE LA CANASTA ALIMENTARIA<br>
                                    PROGRAMA INTEGRAL DE LAS PERSONAS DE LA TERCERA EDAD - YACUIBA
                                </b>
                            </td>
                            <td width="20%" class="align-center linea-superior linea-derecha linea-inferior">
                                <img src="{{ ('logos/mapa.png') }}" class="logo-nueva-historia-sm" alt="#"/>
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
                                    $imagePath = substr($array_entrega[$cont]->beneficiario->dir_foto, 3);
                                    $imageData = '';
                                    if (file_exists($imagePath)) {
                                        $imageData = $imagePath;
                                    } else {
                                        $defaultImagePath = public_path('logos/d3.jpg');
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
                            <td rowspan="2" class="linea-derecha align-superior font-verdana-9">
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
                                Fecha de impresion: {{ \Carbon\Carbon::now()->translatedFormat('d \\d\\e F \\d\\e Y H:i:s') }}
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
                            <td colspan="3" class="align-center linea-izquierda linea-inferior linea-derecha linea-superior font-verdana-9">
                                <b class="text-color-green">Una Nueva Historia... Jose Luis Abrego Gobernador - Gestion {{ $array_entrega[$cont]->paquete->gestion }} RUMBO AL BICENTENARIO</b>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="page-break">

                </div>
            @endif
            @php
                $cont++;
            @endphp
        @endwhile
    </body>
</html>
