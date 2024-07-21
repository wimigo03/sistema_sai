<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html {
            margin: 25px 30px 25px 30px;
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
        .font-verdana-9 {font-size: 9px; font-family: verdana,arial,helvetica;}
        .font-verdana-8 {font-size: 8px; font-family: verdana,arial,helvetica;}

        .align-center {
            text-align: center;
        }

        .align-middle {
            vertical-align: middle;
        }

        .align-superior {
            vertical-align: top;
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
    </style>
    <body>
        <div class="container">
            <img src="{{ ('logos/canastaalimentaria.jpeg') }}" class="watermark" alt="#"/>
            <table class="font-verdana-11" cellspacing="0" cellpadding="0" width="100%" style="width: 100%; padding: 0px; margin: 0;">
                <tr>
                    <td width="20%" class="align-center">
                        <img src="{{ ('logos/gobiernoregional.jpg') }}" width="90px" alt="#"/>
                    </td>
                    <td class="align-center align-middle" style="vertical-align: bottom;">
                        <b>
                            BENEFICIARIOS
                        </b>
                    </td>
                    <td width="20%" class="align-center align-superior">
                        <img src="{{ ('logos/mapa.png') }}" width="100px" alt="#"/>
                    </td>
                </tr>
            </table>
            <br>
            <center>
                <table align="center" cellspacing="0" cellpadding="0" style="width: 95%; padding: 0px;">
                    <thead>
                        <tr class="font-verdana-9 linea-superior-gris linea-inferior-gris linea-izquierda-gris linea-derecha-gris">
                            <th class="linea-derecha-gris" align="center">N°</th>
                            <th class="linea-derecha-gris" align="center">DISTRITO</th>
                            <th class="linea-derecha-gris" align="center">BARRIO</th>
                            <th class="linea-derecha-gris" align="center">N° CARNET</th>
                            <th class="linea-derecha-gris" align="center">NOMBRES</th>
                            <th class="linea-derecha-gris" align="center">APELLIDO PATERNO</th>
                            <th class="linea-derecha-gris" align="center">APELLIDO MATERNO</th>
                            <th class="linea-derecha-gris" align="center">EDAD</th>
                            <th class="linea-derecha-gris" align="center">REGISTRO</th>
                            <th class="linea-derecha-gris" align="center">-</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($beneficiarios as $datos)
                            <tr class="font-verdana-8 linea-inferior-gris linea-izquierda-gris linea-derecha-gris">
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $cont++ }}</td>
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->distrito->nombre }}</td>
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->barrio->nombre }}</td>
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->ci . ' ' . $datos->expedido }}</td>
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->nombres }}</td>
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->ap }}</td>
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->am }}</td>
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->age : '' }}</td>
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->created_att != null ? \Carbon\Carbon::parse($datos->created_att)->format('d/m/Y') : '' }}</td>
                                <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">
                                    @php
                                        $imagePath = 'imagenes/fotos-25px/' . $datos->photo;
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
                                    <img src="{{ $imageData }}" width="25px" style="border-radius: 20%; overflow: hidden;" alt="#"/>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </center>
        </div>
    </body>
</html>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $pdf->text(45, 595, "{{ strtoupper(Auth()->user()->name) }} | {{ date('d/m/Y | H:i') }}", "sans-serif", 6);
            $pdf->text(875, 595, "$PAGE_NUM de $PAGE_COUNT", "sans-serif", 6);
        ');
    }
</script>
