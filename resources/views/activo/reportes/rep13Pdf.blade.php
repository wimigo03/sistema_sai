<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ASIGNACION INDIVIDUAL DE BIENES</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    @include('activo.reportes._styles')
</head>

<body>
    <main>
        @foreach ($activosPorPagina as $index => $productosPagina)
            <header>
                @include('activo.reportes._header', ['title' => 'ASIGNACION INDIVIDUAL DE BIENES'])
                <table class="table-data">
                    <tr>
                        <td width="40%">
                            <h5>ENTIDAD: {{ $entidad->entidad }} {{ $entidad->desc_ent }}</h5>
                            <h5>RESPONSABLE: {{ $responsable->nombres }} {{ $responsable->ap_pat }}
                                {{ $responsable->ap_mat }}</h5>
                            <h5>CARGO:{{ $responsable->file->cargo }}</h5>
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
                            <th>DESCRIPCION DE ACTIVO</th>
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
                    <tfoot>
                        <tr>
                            <td colspan="4">Cantidad: {{ $totalPorPagina }}</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <i>El servidor público queda prohibido de usar o permitir el uso de los bienes para
                                    beneficio particular o privado, prestar o transferir el bien a otro empleado
                                    público, enajenar el bien por cuenta propia,
                                    dañar o alterar sus características físicas o técnicas, poner en riesgo el bien,
                                    ingresar o sacar bienes particulares sin autorización de la Unidad o Responsable de
                                    Activos Fijos.
                                    <br>
                                    La no observancia a estas prohibiciones generará responsabilidades establecidas en
                                    la Ley Nº 1178 y sus reglamentos.
                                    <br>
                                    En señal de conformidad y aceptación se firma el presente acta.</i>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <footer>
                @include('activo.reportes._footer')
            </footer>
        @endforeach
    </main>
</body>

</html>
