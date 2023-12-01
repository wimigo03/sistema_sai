<table>
    <thead>
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
            <th>ID BIEN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($activos as $activo)
            <tr>
                <td>{{ $activo->codigo }}</td>
                <td>{{ $activo->descrip }}</td>
                <td>{{ $activo->costo }}</td>
                <td>{{ $activo->costo }}</td>
                <td>{{ $activo->feul }}</td>
                <td>{{ $activo->costo }}</td>
                <td>{{ $activo->depreciacion_gestion }}</td>
                <td>{{ $activo->depreciacion }}</td>
                <td>{{ $activo->valor_neto }}</td>
                <td>{{ $activo->codconts->nombre }}</td>
                <td>{{ $activo->auxiliars->nomaux }}</td>
                <td>{{ $activo->areas->nombrearea }}</td>
                <td>
                    {{ $activo->empleados->nombres }} {{ $activo->empleados->ap_pat }}
                    {{ $activo->empleados->ap_mat }}
                </td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>TOTALES</td>
            <td></td>
            <td>{{ $totalCostos }}</td>
            <td>{{ $totalCostos }}</td>
            <td></td>
            <td>{{ $totalCostos }}</td>
            <td>{{ $totalDepreciacionAnual }}</td>
            <td>{{ $totalDepreciacion }}</td>
            <td>{{ $totalValorNeto }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>
