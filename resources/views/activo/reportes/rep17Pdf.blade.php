<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>INVENTARIO ORDENADO POR GRUPO CONTABLE Y ORGANISMO</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
   @include('activo.reportes._styles')
</head>

<body>
    <main>
        @foreach ($activosPorPagina as $index => $productosPagina)
        <header>
            @include('activo.reportes._header', ['title' => 'INVENTARIO ORDENADO POR GRUPO CONTABLE Y ORGANISMO'])
            <table class="table-data">
                <tr>
                    <td width="40%">
                        <h5>ENTIDAD: {{ $entidad->entidad }} {{ $entidad->desc_ent }}</h5>
                        <h5>GRUPO CONTABLE: {{ $grupo->nombre }}</h5>
                    </td>
                    <td class="align-top">
                        <h5>UNIDAD: {{ $unidad->unidad }} <span class="ml-3">{{ $unidad->descrip }}</span></h5>
                    </td>
                </tr>
            </table>
        </header>
            <div class="page-content page-{{ $index + 1 }}">
                <table class="main-table">
                    <thead style="background:rgb(208, 208, 235);">
                        <tr>
                            <th style="padding: 6px">CODIGO</th>
                            <th>CODIGO ADICIONAL</th>
                            <th>DESCRIPCION</th>
                            <th>COSTO ACTUAL FINAL</th>
                            <th>VALOR NETO FINAL</th>
                            <th>ORGANIZMO FINANCIADOR</th>
                            <th>ID BIEN</th>
                            <th>N CONVENIO</th>
                            <th>INCORPORACION ESPECIAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productosPagina as $activo)
                            <tr>
                                <td style="height: 6%">{{ $activo['codigo'] }}</td>
                                <td></td>
                                <td>{{ $activo['descrip'] }}</td>
                                <td>{{ $activo['costo'] }}</td>
                                <td>{{ $activo['valor_neto'] }}</td>
                                <td>{{ $activo['org_fin'] }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
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
