<table>
    <thead>
        <tr>
            <th align="center"><b>N°</b></th>
            <th align="center"><b>AREA</b></th>
            <th align="center"><b>CARGO</b></th>
            <th align="center"><b>CARGO SALARIAL</b></th>
            <th align="center"><b>PERSONAL ACTUAL</b></th>
            <th align="center"><b>HABER BASICO</b></th>
            <th align="center"><b>CATEGORIA</b></th>
            <th align="center"><b>N. ADM.</b></th>
            <th align="center"><b>CLASE</b></th>
            <th align="center"><b>N. SAL.</b></th>
            <th align="center"><b>TIPO</b></th>
            <th align="center"><b>ESTADO</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($files as $datos)
            <tr>
                <td align="left">{{ $datos->numfile }}</td>
                <td align="left">{{ $datos->area->nombrearea }}</td>
                <td align="left">{{ $datos->cargo }}</td>
                <td align="left">{{ $datos->nombrecargo }}</td>
                @if ($datos->estadofile == '1')
                    <td align="left">{{ $datos->empleado_actual }}</td>
                @else
                    <td align="left">ACEFALO</td>
                @endif
                <td align="right">{{ number_format($datos->habbasico,2,'.',',') }}</td>
                <td align="center">{{ $datos->categoria }}</td>
                <td align="center">{{ $datos->niveladm }}</td>
                <td align="center">{{ $datos->clase }}</td>
                <td align="center">{{ $datos->nivelsal }}</td>
                <td align="center">{{ $datos->tipos }}</td>
                <td align="center">{{ $datos->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
