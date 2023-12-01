<table>
    <tr>
        <td><b>CODIGO</b></td>
        <td><b>NOMBRE</b></td>
        <td><b>TIPO</b></td>
        <td><b>DISTRITO</b></td>
        <td><b>ESTADO</b></td>
    </tr>
    @foreach ($barrios as $datos)
        <tr>
            <td>{{ $datos->idBarrio }}</td>
            <td>{{ $datos->barrio }}</td>
            <td>{{ strtoupper($datos->tipo) }}</td>
            <td>{{ $datos->distrito }}</td>
            <td>{{ $datos->status }}</td>
        </tr>
    @endforeach
</table>