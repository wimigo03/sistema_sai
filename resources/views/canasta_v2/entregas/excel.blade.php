<table>
    <tr>
        <td align="center"><b>CODIGO</b></td>
        <td><b>TIPO</b></td>
        <td><b>NOMBRE</b></td>
        <td><b>DISTRITO</b></td>
        <td><b>DEA</b></td>
        <td><b>USUARIO</b></td>
        <td align="center"><b>ESTADO</b></td>
    </tr>
    @foreach ($barrios as $datos)
        <tr>
            <td align="center">{{ $datos->id }}</td>
            <td>{{ $datos->tipo_b }}</td>
            <td>{{ $datos->nombre }}</td>
            <td>{{ $datos->distrito->nombre }}</td>
            <td>{{ $datos->dea->nombre }}</td>
            <td>{{ strtoupper($datos->user->name) }}</td>
            <td align="center">{{ $datos->status }}</td>
        </tr>
    @endforeach
</table>