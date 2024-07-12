<!DOCTYPE html>
<html lang="en">


<div class="page-header" align="center">
    <img src="{{ asset('logos/header.jpg') }}" width="900px" height="70px" />
</div>


<div align="center">
    <h3 style="color: red">PRE-AGENDA</h3>

    <h3 >JOSE LUIS ABREGO EJECUTIVO REGIONAL DEL GRAN CHACO</h3>

    <h3 >{{ $fechaliteral }}</h3>

</div>


<table border="1" cellspacing="0" cellpadding="0" width="100%"  style=" border: 1px solid black;border-collapse: collapse;font-size:11px">
    <thead>
        <tr>
            <td style="text-align: center" bgcolor="#E9E6C5"><b>HORA</b></td>
            <td style="text-align: center" bgcolor="#E9E6C5"><b>EVENTO</b></td>
            <td style="text-align: center" bgcolor="#E9E6C5"><b>DETALLE</b></td>
            <td style="text-align: center" bgcolor="#E9E6C5"><b>COORDINAR</b></td>
            <td style="text-align: center" bgcolor="#E9E6C5"><b>LUGAR</b></td>

        </tr>
    </thead>
    <tbody>

        @forelse ($event as $evento)
            <tr>
                <td class="text-justify p-1">{{ Carbon\Carbon::parse($evento->horaini)->format('H:i') }}</td>
                <td class="text-right p-1"> {{ $evento->titulo }}</td>
                <td class="text-right p-1">{{ $evento->descripcion }}</td>
                <td class="text-right p-1">{{ $evento->coordinar }}</td>
                <td class="text-right p-1">{{ $evento->lugar }}</td>

            </tr>
        @endforeach
    </tbody>

</table>



{{--<script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Serif", "normal");
                $pdf->text(50, 770, "{{ date('d-m-Y H:i') }} / {{ Auth()->user()->name }}", $font, 7);
                $pdf->text(530, 765, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 7);
            ');
        }
    </script>--}}
</body>

</html>
