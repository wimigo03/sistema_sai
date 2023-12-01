<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>REPORTE DE TRANSFERENCIA DE ACTIVOS</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    @include('activo.reportes._styles')
</head>

<body>
    <main>
        @foreach ($activosPorPagina as $index => $productosPagina)
            <header>
                @include('activo.reportes._header', ['title' => 'REPORTE DE TRANSFERENCIA DE ACTIVOS'])
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
                </table>
            </header>
            <div class="page-content page-{{ $index + 1 }}">
                <table class="main-table">
                    <thead style="background:rgb(208, 208, 235);">
                        <tr>
                            <th style="height:5%;">CODIGO</th>
                            <th>DESCRIPCION</th>
                            <th>OFICINAS</th>
                            <th>HISTORIAL DEL ACTIVO FIJO</th>
                            <th>RESPONSABLE</th>
                            <th>UNIDAD ADMINISTRATIVA</th>
                            <th>FECHA DE TRANSFERENCIA</th>
                        </tr>
                    </thead>
                    <tbody class="align-top">
                        @foreach ($productosPagina as $activo)
                            <tr>
                                <td style="height: 24%;">{{ $activo['codigo'] }}</td>
                                <td colspan="6">
                                    {{ $activo['descrip'] }}
                                </td>
                            </tr>
                            @foreach ($activo['transferencias'] as $transferencia)
                                <tr align="center">
                                    <td colspan="2"></td>
                                    <td>OFICINA Y RESPONSABLE ANTERIOR</td>
                                    <td>
                                        {{ $transferencia['empleado_saliente']['empleadosareas']['nombrearea'] }}
                                    </td>
                                    <td>
                                        {{ $transferencia['empleado_saliente']['nombres'] }}
                                    </td>
                                    <td>{{ $activo['unidad'] }}</td>
                                    <td>{{ $transferencia['created_at'] }}</td>
                                </tr>
                            @endforeach
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
