<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>KARDEX DE ACTIVOS</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    <style>
    @page {
        margin: 0cm 0cm;
        font-family: sans-serif;
    }

    .table-data {
        width: 100%;
        background: white;
        border-collapse:separate;
        font-size: 10px;
        margin-bottom: 10px;
    }

    .main-table {
        width: 100%;
        height: 70%;
        font-size: 11px;
        border: 1px;
    }

    .main-table>thead>th {
        padding: 5px;
        text-align: left;
    }

    .main-table>tbody>td {
        height: 9%;
        border: 1px solid #000;
        background: red;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        padding: 0;
        margin: 0;
    }

    .logo {
        width: 130px;
        height: 80px;
        margin-bottom: 15px;
    }

    .mr-3 {
        margin-right: 1.5rem;
    }

    .ml-3 {
        margin-left: 1.5rem !important;
    }

    .text-end {
        text-align: right !important;
    }

    .align-top {
        vertical-align: top;
    }

    .border-content {
        border-radius: 10px;
        border: 1px solid black;
        padding: 0 10px
    }

    .border-content-2 {
        border-radius: 10px;
        border: 2px solid black;
        padding: 0 10px
    }

    body {
        margin-top: 5.5cm;
        margin-left: 1cm;
        margin-right: 1cm;
        margin-bottom: 2.6cm;
    }

    header {
        position: fixed;
        font-weight: 800;
        height: 170px;
        top: 1cm;
        left: 1cm;
        right:1cm;
    }
    footer {
        position: fixed;
        bottom: 1cm;
        left: 1cm;
        right: 1cm;
    }
    </style>

</head>

<body>
    <header>
        <table style="width: 100%; border: .8px solid #000;">
            <tr>
                <td style="width: 15%; border-right:1px solid #000;">
                    <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/activos-fijos.jpg'))) }}"
                        width="100%" alt="Imagen">
                </td>
                <td style="width: 70%; text-align: center; vertical-align: middle;">
                    <h2>KARDEX DE ACTIVOS</h2>
                    <h3 style="font-size: 12px; padding-top: 12px;">GOBIERNO AUTONOMO REGIONAL DEL GRAN CHACO
                    </h3>
                </td>
                <td style="width: 15%; text-align: right; vertical-align: top; border-left:1px solid #000;">
                    <img width="100%"
                        src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/logoderecha2.jpg'))) }}"
                        alt="Imagen">
                    <h5 style="font-size: 10px; text-align: center">D.S. 0181</h5>
                    <h5 style="font-size: 10px; text-align: center">Art. 146</h5>
                </td>
            </tr>
        </table>
        <table class="table-data" style="width: 100%;">
            <tr>
                <td style="width:35%;">
                    <h5 style="padding-top: 5px;">ENTIDAD {{ $entidad->entidad }}: {{ $entidad->desc_ent }}</h5>
                    <h5 style="padding-top: 5px;">RESPONSABLE: {{ $responsable->full_name }}</h5>
                    <h5 style="padding-top: 5px;">CARGO: {{ $responsable->file->nombrecargo }}</h5>
                </td>
                <td style="width:35%;">
                    <h5 style="padding-top: 5px">UNIDAD: {{ $unidad->unidad }} <span
                            style="padding-left: 10px">{{ $unidad->descrip }}</span></h5>
                    <h5 style="padding-top: 5px">OFICINA: {{ $responsable->empleadosareas->nombrearea }}</h5>
                    <h5 style="padding-top: 5px">CI: {{ $responsable->ci }}</h5>
                </td>
                <td style="width:11%; text-align:right; ">
                    <h5 style="padding-top: 5px;">FECHA:{{ date('d/m/Y') }}</h5>
                    <h5 style="padding-top: 5px;">HORA:{{ date('H:i:s') }}</h5>
                    <H5 style="padding-top: 5px;">Cant. : {{ count($activos) }} Activos</H5>
                </td>
            </tr>
        </table>
    </header>
    <footer>
        @include('activo.reportes._footer')
    </footer>
    <main>
        <table class="main-table align-top" style="width: 100%;font-size:9px;">
            <thead style="background:rgb(208, 208, 235);">
                <tr>
                    <th style="padding: 6px 0;">CODIGO</th>
                    <th style="padding: 6px 0;">AUXILIAR</th>
                    <th style="padding: 6px 0;">KARDEX DE OBSERVACIONES</th>
                    <th style="padding: 6px 0;">ESTADO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activos as $activo)
                    <tr class="align-top" style="text-align: center">
                        <td style="padding: 10px 0">{{ $activo['codigo'] }}</td>
                        <td style="padding: 10px 0">{{ $activo['auxiliars']['nomaux'] ?? '' }}</td>
                        <td style="padding: 10px 0; text-align:left">{{ $activo['observaciones'] }}</td>
                        <td style="padding: 10px 0">
                            @php
                                $estados = [
                                    1 => 'BUENO',
                                    2 => 'REGULAR',
                                    3 => 'MALO',
                                ];
                                $estado = isset($estados[$activo['codestado']]) ? $estados[$activo['codestado']] : 'Desconocido';
                            @endphp
                            {{ $estado }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
