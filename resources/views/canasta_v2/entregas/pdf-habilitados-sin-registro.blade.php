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
        <div class="container">
            <img src="{{ ('logos/canastaalimentaria.jpeg') }}" class="watermark" alt="#"/>
            <table class="font-verdana-11" cellspacing="0" cellpadding="0" width="100%" style="width: 100%; padding: 0px; margin: 0;">
                <tr>
                    <td width="20%" class="align-center">
                        <img src="{{ ('logos/gobiernoregional.jpg') }}" class="logo-gran-chaco" alt="#"/>
                    </td>
                    <td class="align-center align-middle" style="vertical-align: bottom;">
                        <b>
                            <span class="font-verdana-12">
                                AFILIADOS "{{ $paquete_barrio->barrio->nombre }}"
                            </span>
                            <br>
                            {{ $paquete_barrio->paquete->numero }} ENTREGA - GESTION {{ $paquete_barrio->paquete->gestion }}
                            <br>
                            <span class="font-verdana-10">
                                ({{ $paquete_barrio->periodos }})
                            </span>
                        </b>
                    </td>
                    <td width="20%" class="align-center align-superior">
                        <img src="{{ ('logos/mapa.png') }}" class="logo-nueva-historia" alt="#"/>
                    </td>
                </tr>
            </table>
            <br>
            <table align="center" cellspacing="0" cellpadding="0" style="width: 80%; padding: 0px;">
                <thead>
                    <tr class="font-verdana-9 linea-superior-gris linea-inferior-gris linea-izquierda-gris linea-derecha-gris">
                        <th class="linea-derecha-gris" align="center">N°</th>
                        <th class="linea-derecha-gris" align="center">FOTO</th>
                        <th class="linea-derecha-gris" align="center">N° CARNET</th>
                        <th class="linea-derecha-gris" align="center">NOMBRES</th>
                        <th class="linea-derecha-gris" align="center">APELLIDO PATERNO</th>
                        <th class="linea-derecha-gris" align="center">APELLIDO MATERNO</th>
                        <th class="linea-derecha-gris" align="center">FECHA NAC.</th>
                        <th class="linea-derecha-gris" align="center">EDAD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entregas as $datos)
                        <tr class="font-verdana-9 linea-inferior-gris linea-izquierda-gris linea-derecha-gris">
                            <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $cont++ }}</td>
                            <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">
                                @php
                                    $imagePath = substr($datos->dir_foto, 3);
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
                                <img src="{{ $imageData }}" class="img-beneficiario-pdf" alt="#"/>
                            </td>
                            <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->ci . ' ' . $datos->expedido }}</td>
                            <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->nombres }}</td>
                            <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->ap }}</td>
                            <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->am }}</td>
                            <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->format('d/m/Y') : '' }}</td>
                            <td class="linea-derecha-gris" align="center" style="vertical-align: middle;">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->age : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("verdana");
            $pdf->text(30, 910, "{{ date('d-m-Y H:i') }} / {{ Auth()->user()->name }}", $font, 7);
            $pdf->text(540, 910, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 7);
        ');
    }
</script>
