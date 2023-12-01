<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>INVENTARIO ORDENADO POR CODIGO DE ACTIVO</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    @include('activo.reportes._styles')
</head>

<body>
    <main>
        @foreach ($activosPorPagina as $index => $productosPagina)
            <header>
            @include('activo.reportes._header', ['title' => 'INVENTARIO ORDENADO POR OFICINA Y RESPONSABLE'])
            <table class="table-data">
                    <tr>
                        <td width="40%"><h5>ENTIDAD: {{ $entidad->entidad }} {{ $entidad->desc_ent }}</h5> <h5>OFICINA: {{ $responsable->empleadosareas->nombrearea }}</h5>
                            <h5>RESPONSABLE: {{ $responsable->nombres }} {{ $responsable->ap_pat }} {{ $responsable->ap_mat }}</h5></td>
                        <td class="align-top"><h5>UNIDAD: {{ $unidad->unidad }} <span class="ml-3">{{ $unidad->descrip }}</span></h5></td>
                        <td class="text-end align-top"><h5>INDICE UFV: 2.35998</h5></td>
                    </tr>
                </table>
            </header>
            <div class="page-content page-{{ $index + 1 }}">
                <table class="main-table">
                    <thead style="background:rgb(208, 208, 235);">
                        <tr>
                            <th>CODIGO</th>
                            <th>DESCRIPCION</th>
                            <th>COSTO HISTORICO</th>
                            <th>COSTO MIGRADO</th>
                            <th>FECHA MIGRA FECHA HISTO</th>
                            <th>COSTO TOTAL ACTUALIZADO</th>
                            <th>DEPRECIACION ACUMULADA TOTAL</th>
                            <th>VALOR NETO</th>
                            <th>GRUPO CONTABLE</th>
                            <th>AUX. DE GRUPO</th>
                            <th>OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productosPagina as $activo)
                            <tr>
                                <td>{{ $activo['codigo'] }}</td>
                                <td>{{ $activo['descrip'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['feul'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['depreciacion'] }}</td>
                                <td>{{ $activo['valor_neto'] }}</td>
                                <td>{{ $activo['codconts']['nombre'] ?? '' }}</td>
                                <td>{{ $activo['auxiliars']['nomaux'] ?? '' }}</td>
                                <td>{{ $activo['observaciones'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="border: 1px solid #000;">
                        <tr>
                            <td style="height: 3%">TOTALES</td>
                            <td></td>
                            <td>{{ $totalCostos[$index] }}</td>
                            <td>{{ $totalCostos[$index] }}</td>
                            <td></td>
                            <td>{{ $totalCostos[$index] }}</td>
                            <td>{{ $totalDepreciacionAnual[$index] }}</td>
                            <td>{{ $totalDepreciacion[$index] }}</td>
                            <td>{{ $totalValorNeto[$index] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <footer>
                    @include('activo.reportes._footer')
                </footer>
            </div>
        @endforeach
    </main>
</body>

</html>
