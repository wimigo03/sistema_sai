<table>
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>DESCRIPCION</th>
            <th>COSTO HISTORICO</th>
            <th>FECHA MIGRA FECHA HISTO</th>
            <th>COSTO TOTAL ACTUALIZADO</th>
            <th>DEPRECIACION ACUMULADA TOTAL</th>
            <th>VALOR NETO</th>
            <th>GRUPO CONTABLE</th>
            <th>AUXILIAR DE GRUPO</th>
            <th>OBSERVACIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($activos as $activo)
            <tr>
                <td>{{ $activo->codigo }}</td>
                <td>{{ $activo->descrip }}</td>
                <td>{{ $activo->costo }}</td>
                <td>{{ $activo->feul }}</td>
                <td>{{ $activo->costo }}</td>
                <td>{{ $activo->depreciacion }}</td>
                <td>{{ $activo->valor_neto }}</td>
                <td>{{ $activo->codconts->nombre }}</td>
                <td>{{ $activo->auxiliars->nomaux }}</td>
                <td>{{ $activo->observaciones }}</td>
            </tr>
            @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">CANTIDAD DE ACTIVOS: {{ count($activos) }}</td>
            <td colspan="2">TOTALES</td>
            <td>{{ $totalCostos }}</td>
            <td>{{ $totalDepreciacion }}</td>
            <td>{{ $totalValorNeto }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>
