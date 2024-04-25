<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta name="generator" content="Aspose.Words for .NET 23.12.0" />
    <title></title>
    <link href="{{ asset('tablas.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        body {
            line-height: 108%;
            font-family: Calibri;
            font-size: 11pt
        }

        p {
            margin: 0pt 0pt 8pt
        }

        table {
            margin-top: 0pt;
            margin-bottom: 8pt
        }

        .page-break {
            page-break-after: always;
        }

        .BalloonText {
            margin-bottom: 0pt;
            line-height: normal;
            font-family: 'Segoe UI';
            font-size: 9pt
        }

        .NoSpacing {
            margin-bottom: 0pt;
            line-height: normal;
            font-size: 11pt
        }

        span.TextodegloboCar {
            font-family: 'Segoe UI';
            font-size: 9pt
        }

        .TableGrid {}


    </style>
</head>

<body>
    <div>
        <div align='center'>

                            <h2 class="box-title text-center"><b>AFILIADOS&nbsp;"{{ $entrega_barrio->barrio->nombre }}"</b></h2>
                            <h5 class="text-center"><b>( {{ $entrega_barrio->paquete->numero }} ENTREGA - GESTIÓN {{ $entrega_barrio->paquete->gestion }} )</b></h5>
                            <h5 class="text-center"><b>( {{ $entrega_barrio->paquete->periodo }} )</b></h5>
                        </div>
        <table width="900" align="center" HEIGHT="410" class="tabla1 fondo_tabla">
            <thead>
                <tr >
                    <td style=" border-bottom: 1px solid #ccc;">NRO.</td>
                    <td style=" border-bottom: 1px solid #ccc;">FOTO</td>
                    <td style=" border-bottom: 1px solid #ccc;">C.I.</td>
                    <td style=" border-bottom: 1px solid #ccc;">NOMBRE</td>
                    <td style=" border-bottom: 1px solid #ccc;">APELLIDO PATERNO</td>
                    <td style=" border-bottom: 1px solid #ccc;">APELLIDO MATERNO</td>
                    <td style=" border-bottom: 1px solid #ccc;">F.NACIMIENTO</td>
                    <td style=" border-bottom: 1px solid #ccc;">F.REGISTRO</td>


                </tr>
            </thead>
            @php
                $num = 1;
            @endphp
            @foreach ($entregas as $entrega)

                <tr >
                    <td style=" border-bottom: 1px solid #ccc;">{{$num++}}</td>
                    <td style=" border-bottom: 1px solid #ccc;"><img src="{{ asset(substr($entrega->dirFoto , 3)) }}" align="center" height="30" with="30" /></td>
                    <td style=" border-bottom: 1px solid #ccc;">{{ $entrega->ci }}</td>
                    <td style=" border-bottom: 1px solid #ccc;">{{ $entrega->nombres }}</td>
                    <td style=" border-bottom: 1px solid #ccc;">{{ $entrega->ap }}</td>
                    <td style=" border-bottom: 1px solid #ccc;">{{ $entrega->am }}</td>
                    <td style=" border-bottom: 1px solid #ccc;">{{ $entrega->fechaNac }}</td>
                    <td style=" border-bottom: 1px solid #ccc;"> {{ \Carbon\Carbon::parse($entrega->created_att)->format('d/m/Y') }}</td>
                </tr>
            @endforeach

        </table>
    </div>

</body>

</html>
