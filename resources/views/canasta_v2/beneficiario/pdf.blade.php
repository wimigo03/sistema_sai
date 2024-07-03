<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Beneficario Canasta</title>
    <style>
        <?php echo file_get_contents(public_path('css/font-verdana-pdf.css')); ?>
        html {
            margin: 10px 50px 10px 50px;
        }
    </style>
    <body>
        <table class="table-100">
            <tr>
                <td width="15%">
                    <img src="{{ ('logos/gobiernoregional.jpg') }}" class="logo-gran-chaco" alt="#"/>
                </td>
                <td class="font-verdana-13 align-center align-inferior">
                    <b>GOBIERNO AUTONOMO REGIONAL DEL GRAN CHACO<br>YACUIBA</b>
                </td>
                <td width="15%" class="align-right">
                    <img src="{{ ('logos/logoderecha.png') }}" class="logo-nueva-historia" alt="#"/>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="font-verdana-13 align-center align-middle">
                    <b>CANASTA ALIMENTARIA</b>
                </td>
            </tr>
        </table>
        <table class="font-verdana-11" cellspacing="0" cellpadding="0" style="width:100%; border-collapse: collapse;">
            <tr>
                <td width="20%">
                    <b>Nro. de carnet</b>
                </td>
                <td  width="40%">
                    <b>:</b> {{ $beneficiario->ci . ' ' . $beneficiario->expedido }}
                </td>
                <td rowspan="9" style="vertical-align: top; text-align: center;">
                    <img src="{{ (substr($beneficiario->dir_foto, 2)) }}" id="img-beneficiario" alt="img"/>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Nombres</b>
                </td>
                <td>
                    <b>:</b> {{ $beneficiario->nombres }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Apellido Paterno</b>
                </td>
                <td>
                    <b>:</b> {{ $beneficiario->ap }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Apellido Materno</b>
                </td>
                <td>
                    <b>:</b> {{ $beneficiario->am }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Fecha de Nacimiento</b>
                </td>
                <td>
                    <b>:</b> {{ \Carbon\Carbon::parse($beneficiario->fecha_nac)->format('d/m/Y') }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Edad</b>
                </td>
                <td>
                    <b>:</b> {{ \Carbon\Carbon::parse($beneficiario->fecha_nac)->age }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Estado Civil</b>
                </td>
                <td>
                    <b>:</b> {{ $beneficiario->estado_civil }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Genero</b>
                </td>
                <td>
                    <b>:</b> {{ $beneficiario->sexo }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Ocupacion</b>
                </td>
                <td>
                    <b>:</b> {{ $beneficiario->ocupacion->ocupacion }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Barrio / Comunidad</b>
                </td>
                <td>
                    <b>:</b> {{ $beneficiario->barrio->nombre }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Direccion</b>
                </td>
                <td colspan="2">
                    <b>:</b> {{ $beneficiario->direccion }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Firma</b>
                </td>
                <td colspan="2">
                    <b>:</b> {{ $beneficiario->firma }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Fecha de Registro</b>
                </td>
                <td>
                    <b>:</b> {{ \Carbon\Carbon::parse($beneficiario->created_att)->format('d/m/Y') }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Estado</b>
                </td>
                <td colspan="2">
                    <b>:</b> {{ $beneficiario->status }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Observaciones</b>
                </td>
                <td colspan="2">
                    <b>:</b> {{ $beneficiario->obs }}
                </td>
            </tr>
        </table>
        @isset($historial)
            <br>
            <b class="font-verdana-10">HISTORIAL</b>
            <table class="font-verdana-10" cellspacing="0" cellpadding="0" style="width:80%; border-collapse: collapse;">
                <thead>
                    <tr class="linea-superior-gris linea-inferior-gris linea-izquierda-gris linea-derecha-gris">
                        <th>FECHA</th>
                        <th>OBSERVACION</th>
                        <th align="center">USUARIO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historial as $datos)
                        <tr class="linea-superior-gris linea-inferior-gris linea-izquierda-gris linea-derecha-gris">
                            <td>{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                            <td>{{ strtoupper($datos->observacion) }}</td>
                            <td align="center">{{ $datos->user != null ? $datos->user->name : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endisset
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
