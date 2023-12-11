<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>RESUMEN DE ACTIVOS FIJOS ORDENADO POR GRUPO CONTABLE Y MOVIMIENTOS</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    @include('activo.reportes._styles')
</head>

<body>
    <main>
        @foreach ($activosPorPagina as $index => $productosPagina)
            <header>
                @include('activo.reportes._header', [
                    'title' => 'RESUMEN DE ACTIVOS FIJOS ORDENADO POR GRUPO CONTABLE Y MOVIMIENTOS',
                ])
                <table class="table-data">
                    <tr>
                        <td width="40%">
                            <h5>ENTIDAD: {{ $entidad->entidad }} {{ $entidad->desc_ent }}</h5>
                        </td>
                        <td class="text-top">
                            <h5>UNIDAD: {{ $unidad->unidad }}
                                <span class="ml-3">{{ $unidad->descrip }}</span>
                            </h5>
                        </td>
                        <td class="text-end text-top">
                            <h5>INDICE UFV: 2.35998 Bs.</h5>
                        </td>
                    </tr>
                </table>
            </header>
            <div class="page-content page-{{ $index + 1 }}">
                <table class="main-table">
                    <thead style="background:rgb(208, 208, 235);">
                        <tr>
                            <th>GRUPO CONTABLE</th>
                            <th>CANTIDAD</th>
                            <th>VIDA UTIL</th>
                            <th>COSTO HISTORICO</th>
                            <th>COSTO ACTUAL E INICIAL</th>
                            <th>DEPRECIACION TOTAL DE GRUPO</th>
                            <th>VALOR NETO INICIAL</th>
                            <th>ACTUALIZACION GESTION</th>
                            <th>COSTO TOTAL ACTUALIZADO</th>
                            <th>DEPRECIACION GESTION</th>
                            <th>ACTUALIZACION DEP. ACUM.</th>
                            <th>DEPRECIACION ACUMULADA</th>
                            <th>VALOR NETO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productosPagina as $activo)
                            <tr>
                                <td style="height: 7%;">{{ $activo['nombre'] }}</td>
                                <td>{{ count($activo['actuals']) }}</td>
                                <td>{{ $activo['vidautil'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['depreciacion'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['depreciacion_gestion'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['depreciacion'] }}</td>
                                <td>{{ $activo['depreciacion'] }}</td>
                                <td>{{ $activo['depreciacion'] }}</td>
                                <td>{{ $activo['valor_neto'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="border: 1px solid #000;">
                        <tr>
                            <td style="height: 25px">TOTALES</td>
                            <td>{{ $cantidadGrupos[$index] }}</td>
                            <td></td>
                            <td>{{ $totalCostos[$index] }}</td>
                            <td>{{ $totalCostos[$index] }}</td>
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
