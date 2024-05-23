<table>
    <thead>
        <tr>
            <th align="center"><b>N°</b></th>
            <th align="center"><b>AREA</b></th>
            <th align="center"><b>CARGO</b></th>
            <th align="center"><b>ESCALA SALARIAL</b></th>
            <th align="center"><b>PERSONAL ACTUAL</b></th>
            <th align="center"><b>TIPO</b></th>
            <th align="center"><b>ESTADO</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($files as $datos)
            <tr>
                <td align="left">{{ $datos->numfile }}</td>
                <td align="left">{{ $datos->area->nombrearea }}</td>
                <td align="left">{{ $datos->nombrecargo }}</td>
                <td align="center">{{ $datos->escala_salarial != null ? $datos->escala_salarial->nombre : '-' }}</td>
                @if ($datos->estadofile == '1')
                    <td align="left">{{ $datos->empleado_actual }}</td>
                @else
                    <td align="left">ACEFALO</td>
                @endif
                <td align="center">{{ $datos->tipos }}</td>
                <td align="center">{{ $datos->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
