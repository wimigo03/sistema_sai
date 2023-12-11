<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ACTA DE DEVOLUCION DE BIENES</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
   @include('activo.reportes._styles')
</head>

<body>
    <main>
        @foreach ($activosPorPagina as $index => $productosPagina)
        <header>
            @include('activo.reportes._header', ['title' => 'ACTA DE DEVOLUCION DE BIENES'])
            <table class="table-data">
                <tr>
                    <td width="40%">
                        <h5>ENTIDAD: {{ $entidad->entidad }} {{ $entidad->desc_ent }}</h5>
                        <h5>RESPONSABLE: {{ $responsable->nombres }} {{ $responsable->ap_pat }} {{ $responsable->ap_mat }}</h5>
                        <h5>OFICINA: {{ $responsable->empleadosareas->nombrearea }}</h5>
                    </td>
                    <td class="align-top">
                        <h5>UNIDAD: {{ $unidad->unidad }} <span class="ml-3">{{ $unidad->descrip }}</span></h5>
                        <h5>CI: {{ $responsable->ci }} <span class="ml-3">TAR</span></h5>
                    </td>
                </tr>
            </table>
        </header>
            <div class="page-content page-{{ $index + 1 }}">
                <table class="main-table">
                    <thead style="background:rgb(208, 208, 235);">
                        <tr>
                            <th style="padding: 6px">CODIGO</th>
                            <th>AUXILIAR</th>
                            <th>DESCRIPCION</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productosPagina as $activo)
                            <tr>
                                <td style="height: 6%">{{ $activo['codigo'] }}</td>
                                <td>{{ $activo['auxiliars']['nomaux'] ?? '' }}</td>
                                <td>{{ $activo['descrip'] }}</td>
                                <td>
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
            </div>
            <footer>
                @include('activo.reportes._footer')
            </footer>
        @endforeach
    </main>
</body>

</html>
