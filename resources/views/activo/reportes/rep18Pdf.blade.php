<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>KARDEX CORRELATIVO</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    @include('activo.reportes._styles')
</head>

<body>
    <main>
        @foreach ($activosPorPagina as $index => $productosPagina)
            <header>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 25%;">
                            <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/imagen-pdf.png'))) }}"
                                class="logo" alt="Imagen">
                        </td>
                        <td style="width: 50%; text-align: center; vertical-align: middle;">
                            <h3>KARDEX CORRELATIVO</h3>
                            <br>
                        </td>
                        <td style="width: 25%; text-align: right; vertical-align: top">
                            <table>
                                <tr>
                                    <td style="text-align: right">
                                        <h5>Pag:</h5>
                                    </td>
                                    <td style="text-align: left">
                                        <h5>{{ $index + 1 }}</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        <h5>Hora:</h5>
                                    </td>
                                    <td style="text-align: left">
                                        <h5>{{ date('H:i:s') }}</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        <h5>Fecha:</h5>
                                    </td>
                                    <td style="text-align: left">
                                        <h5>{{ date('d/m/Y') }}</h5>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="table-data">
                    <tr>
                        <td width="50%">
                            <h5>ENTIDAD: {{ $entidad->entidad }} {{ $entidad->desc_ent }}</h5>
                            <h5>RESPONSABLE: {{ $responsable->full_name }}</h5>
                            <h5>CARGO: {{ $responsable->file->cargo }}</h5>
                        </td>
                        <td class="align-top">
                            <h5>UNIDAD: {{ $unidad->unidad }} <span class="ml-3">{{ $unidad->descrip }}</span></h5>
                            <h5>OFICINA: {{ $responsable->empleadosareas->nombrearea }}</h5>
                            <h5>CI: {{ $responsable->ci }}</h5>
                        </td>
                    </tr>
                </table>
            </header>
            <div class="page-content page-{{ $index + 1 }}">
                <table class="main-table">
                    <thead style="background:rgb(208, 208, 235);">
                        <tr>
                            <th style="padding: 6px">CODIGO</th>
                            <th>Auxiliar</th>
                            <th>Kardex de observaciones</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productosPagina as $activo)
                            <tr align="center">
                                <td style="height: 4%">{{ $activo['codigo'] }}</td>
                                <td>{{ $activo['auxiliars']['nomaux'] }}</td>
                                <td>{{ $activo['observaciones'] }}</td>
                                <td>
                                    @if ($activo['codestado'] == 1)
                                        BUENO
                                    @elseif($activo['codestado'] == 2)
                                        REGULAR
                                    @elseif($activo['codestado'] == 3)
                                        MALO
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <footer>
                    <table width="100%">
                        <tr>
                            <td style="width: 33.33%; text-align: center;">
                                <hr style="width: 50%; border-style: dashed">
                                Autorización de asignación
                            </td>
                            <td style="width: 33.33%; text-align: center;">
                                <hr style="width: 50%; border-style: dashed">
                                Responsable de Activos Fijos
                            </td>
                            <td style="width: 33.33%; text-align: center;">
                                <hr style="width: 50%; border-style: dashed">
                                Funcionario
                            </td>
                        </tr>
                    </table>
                </footer>
        @endforeach
        </div>
    </main>
</body>

</html>
