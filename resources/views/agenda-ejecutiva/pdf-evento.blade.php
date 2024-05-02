<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Agenda Ejecutiva</title>
    <style>
        <?php echo file_get_contents(public_path('css/font-verdana-pdf.css')); ?>
    </style>
    <body>
        <table>
            <tr>
                <td width="15%">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/gobiernoregional.jpg'))) }}" class="logo-callejx" alt="#"/>
                </td>
                <td class="font-verdana-15 align-center">
                    <b>GOBIERNO AUTONOMO REGIONAL DEL GRAN CHACO - YACUIBA</b>
                </td>
                <td width="15%" class="align-right">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/logoderecha.png'))) }}" class="logo-callejx" alt="#"/>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="font-verdana-15 align-center align-middle">
                    <b style="color:red;">PRE-AGENDA</b>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="font-verdana-15 align-center align-middle">
                    <b>JOSE LUIS ABREGO EJECUTIVO REGIONAL DEL GRAN CHACO</b>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="font-verdana-15 align-center align-middle">
                    <b><u>{{ ucfirst($fechaliteral) }}</u></b>
                </td>
            </tr>
        </table>
        <br>
        <table class="font-verdana-12">
            <thead class="linea-inferior">
                <tr>
                    <th>HORA</th>
                    <th>EVENTO</th>
                    <th>DETALLE</th>
                    <th>COORDINAR</th>
                    <th>LUGAR</th>
                </tr>
            </thead>
            <tbody class="linea-inferior">
                @foreach ($eventos as $datos)
                    <tr class="linea-inferior font-verdana-11">
                        <td class="text-justify align-superior">{{ Carbon\Carbon::parse($datos->horaini)->format('H:i') }}</td>
                        <td class="text-justify align-superior">{{ $datos->titulo }}</td>
                        <td class="text-justify align-superior">{{ $datos->descripcion }}</td>
                        <td class="text-justify align-superior">{{ $datos->coordinar }}</td>
                        <td class="text-justify align-superior">{{ $datos->lugar }}</td>
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
            $pdf->text(30, 590, "{{ date('d-m-Y H:i') }} / {{ Auth()->user()->name }}", $font, 7);
            $pdf->text(720, 590, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 7);
        ');
    }
</script>
