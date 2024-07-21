<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cronograma de Entrega</title>
    <style>
        html {
            margin: 15px 50px 30px 50px;
        }

        td, th {
            padding: 5px;
        }

        .font-verdana-9 {font-size: 9px; font-family: verdana,arial,helvetica;}
        .font-verdana-10 {font-size: 10px; font-family: verdana,arial,helvetica;}
        .align-superior {
            vertical-align: top;
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
                    <img src="{{ ('logos/gobiernoregional.jpg') }}" width="140px" alt="#"/>
                </td>
                <td align="center" class="align-inferior">
                    <img src="{{ ('logos/canastaalimentaria.jpeg') }}" width="60px" alt="#"/>
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
                    <img src="{{ ('logos/logoderecha-header.png') }}" width="100px"  alt="#"/>
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
            $pdf->text(38, 770, "{{ strtoupper(Auth()->user()->name) }} | {{ date('d/m/Y | H:i') }}", "sans-serif", 6);
            $pdf->text(558, 770, "$PAGE_NUM de $PAGE_COUNT", "sans-serif", 6);
        ');
    }
</script>
