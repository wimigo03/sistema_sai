<table>
    <thead>
        <tr>
            <th align="center"><b>NRO</b></th>
            <th align="center"><b>AREA - UNIDAD</b></th>
            <th align="center"><b>CARGO</b></th>
            <th align="center"><b>ESCALA SALARIAL</b></th>
            <th align="center"><b>NOMBRE(S)</b></th>
            <th align="center"><b>APELLIDO PATERNO</b></th>
            <th align="center"><b>APELLIDO MATERNO</b></th>
            <th align="center"><b>N° CARNET</b></th>
            <th align="center"><b>SEXO</b></th>
            <th align="center"><b>TIPO</b></th>
            <th align="center"><b>INGRESO</b></th>
            <th align="center"><b>RETIRO</b></th>
            <th align="center"><b>ESTADO</b></th>
        </tr>
    </thead>
    <tbody>
        @php
            $cont = 1;
        @endphp
        @foreach ($empleados as $datos)
            <tr>
                <td align="center">{{ $cont++; }}</td>
                <td>{{ $datos->area->nombrearea }}</td>
                <td>{{ $datos->file_cargo }}</td>
                <td>{{ $datos->escala_salarial_file }}</td>
                <td>{{ $datos->nombres }}</td>
                <td>{{ $datos->ap_pat }}</td>
                <td>{{ $datos->ap_mat }}</td>
                <td align="center">{{ $datos->ci .' ' . $datos->extension }}</td>
                <td align="center">{{ $datos->sexos }}</td>
                <td align="center">{{ $datos->ultimo_tipo_contrato }}</td>
                <td align="center">{{ $datos->ultimo_contrato_ingreso != null ? \Carbon\Carbon::parse($datos->ultimo_contrato_ingreso)->format('d/m/Y') : '' }}</td>
                <td align="center">{{ $datos->ultimo_contrato_retiro != null ? \Carbon\Carbon::parse($datos->ultimo_contrato_retiro)->format('d/m/Y') : '' }}</td>
                <td align="center">{{ $datos->status_completo }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
