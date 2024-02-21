<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte codigo de barras - {{ $activo->codigo }}</title>
    <style>
        *{
            font-size: 10px;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        .text-truncate {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            }
    </style>
</head>

<body>
    @for ($i = 0; $i < $cantidad; $i++)
        <table style="width: 90%; margin: 10px 5%; border-collapse: collapse;">
            <tr style="border: 2px solid #000;">
                <td style="width:100%">
                    <h5>GAR. Gran Chaco</h5>
                </td>
                <td style="text-align: right; padding:5px;">
                    <p>{{ $activo->codigo }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 7px 0; text-align: center;">
                    <div style="display: inline-block;">
                        {!! DNS1D::getBarcodeHTML('' . $activo->codigo . '', 'C128', 2.3, 60) !!}
                    </div>
                </td>
            </tr>

            <tr style="border: 2px solid #000;">
                <td colspan="2" style="padding: 3px; max-height:10px;" style="text-truncate">
                    <p class="descripcionStyle">{{ $activo->descrip }}</p>
                </td>
            </tr>
        </table>

        @if ($i < $cantidad - 1)
        <div style="page-break-after:always;"></div>
        @endif
    @endfor

</body>

</html>
