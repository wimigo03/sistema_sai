<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>INVENTARIO ORDENADO POR GRUPO CONTABLE</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    @include('activo.reportes._styles')
</head>

<body>
    <main>
        @foreach ($activosPorPagina as $index => $productosPagina)
            <header>
                @include('activo.reportes._header', ['title' => 'INVENTARIO ORDENADO POR GRUPO CONTABLE'])
                <table class="table-data">
                    <tr>
                        <td width="40%">
                            <h5>ENTIDAD: {{ $entidad->entidad }} {{ $entidad->desc_ent }}</h5>
                            <h5>GRUPO CONTABLE: {{ $grupo->nombre }}</h5>
                        </td>
                        <td>
                            <h5>UNIDAD: {{ $unidad->unidad }} <span class="ml-3">{{ $unidad->descrip }}</span></h5>
                        </td>
                        <td class="text-end">
                            <h5>INDICE UFV: 2.35998</h5>
                        </td>
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
                            <th>COSTO FINAL ACTUALIZADO</th>
                            <th>DEPRECIACION GESTION</th>
                            <th>DEPRECIACION ACUMULADA TOTAL</th>
                            <th>VALOR NETO</th>
                            <th>GRUPO CONTABLE</th>
                            <th>AUX. DE GRUPO</th>
                            <th>OFICINA</th>
                            <th>RESPONSABLE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productosPagina as $activo)
                            <tr>
                                <td style="height: 14%;">{{ $activo['codigo'] }}</td>
                                <td>{{ $activo['descrip'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['ano'] }}-{{ $activo['mes'] }}-{{ $activo['dia'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['depreciacion_gestion'] }}</td>
                                <td>{{ $activo['depreciacion'] }}</td>
                                <td>{{ $activo['valor_neto'] }}</td>
                                <td>{{ $activo['codconts']['nombre'] ?? '' }}</td>
                                <td>{{ $activo['auxiliars']['nomaux'] ?? '' }}</td>
                                <td>{{ $activo['areas']['nombrearea'] ?? '' }}</td>
                                <td>
                                    @if ($activo['empleados'])
                                        {{ $activo['empleados']['nombres'] }} {{ $activo['empleados']['ap_pat'] }}
                                        {{ $activo['empleados']['ap_mat'] }}
                                    @else
                                    @endif
                                </td>
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
