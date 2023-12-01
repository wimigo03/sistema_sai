<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DETALLE DE RESPONSABLES POR OFICINA</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    @include('activo.reportes._styles')
</head>

<body>
    <main>
        @foreach ($activosPorPagina as $index => $productosPagina)
            <header>
                @include('activo.reportes._header', ['title' => 'DETALLE DE RESPONSABLES POR OFICINA'])
                <table class="table-data">
                    <tr>
                        <td width="40%">
                            <h5>ENTIDAD: {{ $entidad->entidad }} {{ $entidad->desc_ent }}</h5>
                        </td>
                        <td class="align-top">
                            <h5>UNIDAD: {{ $unidad->unidad }} <span class="ml-3">{{ $unidad->descrip }}</span></h5>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <h5><span>CODIGO:</span><span class="mr-3">{{ $oficina->idarea }}</span></h5>
                        </td>
                        <td>
                            <h5><span>OFICINA:</span> <span class="mr-3">{{ $oficina->nombrearea }}</span></h5>
                        </td>
                        <td class="text-end">
                            <h5><span>ESTADO:</span> <span
                                    class="mr-3">{{ $oficina->estadoarea == 1 ? 'Activo' : 'Inactivo' }}</span></h5>
                        </td>
                    </tr>
                </table>
            </header>
            <div class="page-content page-{{ $index + 1 }}">
                <table class="main-table">
                    <thead style="background:rgb(208, 208, 235);">
                        <tr>
                            <th style="height:5%;">COD</th>
                            <th>NOMBRE RESPONSABLE</th>
                            <th>CARGO</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productosPagina as $activo)
                            <tr>
                                <td style="height: 5%;">{{ $activo['idemp'] }}</td>
                                <td>
                                    {{ $activo['nombres'] }} {{ $activo['ap_pat'] }} {{ $activo['ap_mat'] }}
                                </td>
                                <td>{{ $activo['file']['cargo'] }}</td>
                                <td>
                                    @php
                                        $estados = [
                                            1 => 'ACTIVO',
                                            2 => 'INACTIVO',
                                        ];
                                        $estado = isset($estados[$activo['estadoemp1']]) ? $estados[$activo['estadoemp1']] : 'Desconocido';
                                    @endphp
                                    {{ $estado }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <footer>
                    @include('activo.reportes._footer')
                </footer>
            </div>
        @endforeach
    </main>
</body>

</html>
