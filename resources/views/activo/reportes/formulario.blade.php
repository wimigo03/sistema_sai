<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>CERTIFICADO DE NO ADEUDO</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    <style>
    @page {
        margin: 0cm 0cm;
        font-family: sans-serif;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    .table-footer{
        border:none;
    }

     th, td {
        border: 1px solid black;
    }
    body {
        margin-top: 1cm;
        margin-left: 1cm;
        margin-right: 1cm;
        margin-bottom: 1cm;
    }

    .mr-3 {
        margin-right: 1.5rem;
    }

    .ml-3 {
        margin-left: 1.5rem !important;
    }

    footer {
        position: fixed;
        bottom: 1cm;
        left: 2.5cm;
        right: 2.5cm;
        font-size: 13px;
    }
    .font-size {
        font-size: 13px
    }

    .font-justify {
        text-align: justify;
    }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;">
            <tr>
                <td style="width: 20%; text-align: left; padding:5px border-bottom:none" rowspan="2">
                    <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/logoizquierda.jpg'))) }}" width="100%" alt="Imagen">
                </td>
                <td style="text-align: center; font-size: 15px;vertical-align: bottom; border-bottom:none">
                    <h4>FORMULARIO TOMA DE INVENTARIO FÍSICO</h4>
                </td>
                <td style="width: 15%; text-align: right;" rowspan="2">
                    <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/activos-fijos.jpg'))) }}" width="100%" height="70px" alt="Imagen">
                </td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: middle;; font-size:11px">
                    GOBIERNO AUTÓNOMO REGIONAL DEL GRAN CHACO
                </td>
            </tr>
        </table>

    </header>
    <footer>
        <table width="100%" class="table-footer">
            <tr>
                <td style="width: 33.33%; text-align: center; border:none">
                    Técnico de Activos Fijos
                    <br>
                    <span style="color: rgb(158, 158, 158)">Firma y sello</span>
                </td>
                <td style="width: 33.33%; text-align: center; border:none">
                    Servidor Público
                    <br>
                    <span style="color: rgb(158, 158, 158)">Firma y sello</span>
                </td>
                <td style="width: 33.33%; text-align: center; border:none">
                    Jefe de Unidad
                    <br>
                    <span style="color: rgb(158, 158, 158)">Firma y sello</span>
                </td>
            </tr>
        </table>
    </footer>
    <main>
        <table style="width: 100%; font-size:11px; border-bottom:none">
            <tr>
                <td style="text-align: right; border-top:none">
                    UBICACION:
                </td>
                <td style="border-top:none">
                    {{ $formulario->empleado->empleadosareas->nombrearea }}
                </td>
                <td style="text-align: right;border-top:none">
                    CUSTODIO:
                </td>
                <td style="border-top:none">
                    {{ $formulario->empleado->full_name }}
                </td>
                <td style="text-align: right; border-top:none">
                    N° FORM:
                </td>
                <td style="border-top:none; text-align:center">
                    {{ str_pad($formulario->id, 3, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
            <tr>
                <td style="text-align: right; border-bottom:none">
                    FECHA:
                </td>
                <td style="border-bottom:none">{{ $formulario->created_at->format('d/m/Y') }}</td>
                <td style="text-align: right; border-bottom:none">
                    CARGO:
                </td>
                <td style="border-bottom:none">
                    {{ $formulario->empleado->file->nombrecargo }}
                </td>
                <td style="text-align: right; border-bottom:none">
                    CI:
                </td>
                <td style="border-bottom:none">
                    {{ $formulario->empleado->ci }}
                </td>
            </tr>
        </table>
        <table style="width:100%; font-size:11px;">
            <thead style="background:#d8d8d8;">
                <tr>
                    <th style="padding:5px 0;">ITEM</th>
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formulario->formularios as $form)
                <tr>
                    <td style="padding: 5px 0;" align="center">{{ $loop->iteration }}</td>
                    <td align="center">{{ $form->activo->codigo }}</td>
                    <td>{{ $form->activo->descrip }}</td>
                    <td align="center">
                        @if($form->activo->codestado == 1)
                        BUENO
                        @elseif($form->activo->codestado == 2)
                        REGULAR
                        @elseif($form->activo->codestado == 3)
                        MALO
                        @else
                        
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p style="font-size:12px">Inventariado por: {{ $formulario->user->usuariosEmpleados->full_name }}</p>
    </main>
</body>

</html>
