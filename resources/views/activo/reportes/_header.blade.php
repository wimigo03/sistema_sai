@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $fecha = Carbon\Carbon::parse(now());
    $mes = $meses[$fecha->format('n') - 1];
    $fecha = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
@endphp

<table style="width: 100%">
    <tr>
        <td style="width: 25%;">
            <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/imagen-pdf.png'))) }}"
                class="logo" alt="Imagen">
        </td>
        <td style="width: 50%; text-align: center; vertical-align: middle;">
            <h3>{{ $title }}</h3>
            <br>
            <h5 style="letter-spacing: 3px;">AL {{ $fecha }}
            </h5>
        </td>
        <td style="width: 25%; text-align: right; vertical-align: top">
            <table>
                <tr>
                    <td style="text-align: right">
                        <h5>Pagina:</h5>
                    </td>
                    <td style="text-align: left">
                        <h5>{{ $index + 1 }}</h5>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">
                        <h5>Fecha de impresion:</h5>
                    </td>
                    <td style="text-align: left">
                        <h5>{{ date('d/m/Y') }}</h5>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">
                        <h5>Responsable de impresion:</h5>
                    </td>
                    <td style="text-align: left">
                        <h5>{{ auth()->user()->name }}</h5>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
