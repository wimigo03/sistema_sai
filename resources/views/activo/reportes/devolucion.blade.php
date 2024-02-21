<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DEVOLUCION DE ACTIVOS</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    @include('activo.reportes._styles')

</head>

<body>
    <header>
        <table style="width: 100%; border: .8px solid #000;">
            <tr>
                <td style="width: 15%; border-right:1px solid #000;">
                    <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/activos-fijos.png'))) }}"
                        width="100%" alt="Imagen">
                </td>
                <td style="width: 70%; text-align: center; vertical-align: middle;">
                    <h2>DEVOLUCION DE ACTIVOS</h2>
                    <h3 style="font-size: 12px; padding-top: 12px;">GOBIERNO AUTONOMO REGIONAL DEL GRAN CHACO
                    </h3>
                </td>
                <td style="width: 15%; text-align: right; vertical-align: top; border-left:1px solid #000;">
                    <img width="100%"
                        src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/logoderecha2.png'))) }}"
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
                    <H5 style="padding-top: 5px;">VSIAF</H5>
                </td>
            </tr>
        </table>
    </header>
    <footer>
        @include('activo.reportes._footer')
    </footer>
    <main>
        <table class="main-table align-top" style="width: 100%;">
            <thead style="background:rgb(208, 208, 235);">
                <tr>
                    <th style="padding: 6px 0;">CODIGO</th>
                    <th style="padding: 6px 0;">AUXILIAR</th>
                    <th style="padding: 6px 0;">DESCRIPCION</th>
                    <th style="padding: 6px 0;">ESTADO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activos as $activo)
                    <tr class="align-top">
                        <td style="padding: 10px 0">{{ $activo['codigo'] }}</td>
                        <td style="padding: 10px 0">{{ $activo['auxiliars']['nomaux'] ?? '' }}</td>
                        <td style="padding: 10px 0">{{ $activo['descrip'] }}</td>
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
