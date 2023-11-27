<table>
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>AUXILIAR</th>
            <th>DESCRIPCION DE ACTIVO</th>
            <th>ESTADO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($activos as $activo)
            <tr>
                <td>{{ $activo->codigo }}</td>
                <td>{{ $activo->auxiliars->nomaux }}</td>
                <td>{{ $activo->descrip }}</td>
                <td>
                    @if ($activo->codestado == 1)
                        BUENO
                    @elseif($activo->codestado == 2)
                        REGULAR
                    @elseif($activo->codestado == 3)
                        MALO
                    @endif
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
