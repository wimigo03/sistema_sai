<table>
    <thead>
        <tr>
            <th>COD</th>
            <th>NOMBRE RESPONSABLE</th>
            <th>CARGO</th>
            <th>ESTADO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleados as $empleado)
            <tr>
                <td>{{ $empleado->idemp }}</td>
                <td>{{ $empleado->nombres }} {{ $empleado->ap_pat }} {{ $empleado->ap_mat }}</td>
                <td>{{ $empleado->file->cargo }}</td>
                <td>
                    @if ($empleado->estadoemp1 == 1)
                        ACTIVO
                    @else
                        INACTIVO
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
