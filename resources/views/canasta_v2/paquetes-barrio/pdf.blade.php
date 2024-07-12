<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cronograma de Entrega</title>
    <style>
        <?php echo file_get_contents(public_path('css/font-verdana-pdf.css')); ?>
        html {
            margin: 15px 50px 30px 50px;
        }

        .my-custom-table,
        .my-custom-table th,
        .my-custom-table td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <body>
        <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td width="20%">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/gobiernoregional.jpg'))) }}" class="logo-gran-chaco" alt="#"/>
                </td>
                <td align="center" class="align-inferior">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/canastaalimentaria.jpeg'))) }}" class="logo-canasta-alimentaria" alt="#"/>
                    <br>
                    <span class="font-verdana-10">
                        <b>
                            GESTION {{ $paquete->gestion }}
                            <br>
                            CRONOGRAMA {{ $paquete->numero }} ENTREGA
                        </b>
                    </span>
                </td>
                <td width="20%" class="align-right">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/logoderecha.png'))) }}" class="logo-nueva-historia" alt="#"/>
                </td>
            </tr>
        </table>
        <table class="font-verdana-9 my-custom-table" cellspacing="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                    <th>DISTRITO</th>
                    <th>BARRIO</th>
                    <th>LUGAR DE ENTREGA</th>
                    <th>DIA</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paquetes_barrios as $datos)
                    <tr class="font-verdana-9">
                        <td align="center" class="align-superior">{{ $datos->distrito->nombre }}</td>
                        <td align="center" class="align-superior">{{ $datos->barrio->nombre }}</td>
                        <td align="center" class="align-superior">{{ $datos->lugar_entrega }}</td>
                        <td align="center" class="align-superior">{{ $datos->fecha_entrega != null ? mb_strtoupper(strftime('%A', strtotime($datos->fecha_entrega)), 'UTF-8') : '' }}</td>
                        <td align="center" class="align-superior">{{ $datos->fecha_entrega != null ? \Carbon\Carbon::parse($datos->fecha_entrega)->format('d/m/Y') : '' }}</td>
                        <td align="center" class="align-superior">
                            @if ($datos->hora_inicio && $datos->hora_final != null)
                                {{ $datos->hora_inicio . ' A ' . $datos->hora_final }}
                            @else
                                {{ $datos->hora_inicio . $datos->hora_final }}
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("verdana");
            $pdf->text(30, 770, "{{ date('d-m-Y H:i') }} / {{ Auth()->user()->name }}", $font, 7);
            $pdf->text(530, 770, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 7);
        ');
    }
</script>
