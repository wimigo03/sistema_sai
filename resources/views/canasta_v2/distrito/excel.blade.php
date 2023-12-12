<table>
    <tr>
        <td align="center"><b>CODIGO</b></td>
        <td><b>NOMBRE</b></td>
        <td align="center"><b>USUARIO</b></td>
        <td align="center"><b>DEA</b></td>
        <td align="center"><b>ESTADO</b></td>
    </tr>
    @foreach ($distritos as $datos)
        <tr>
            <td align="center">{{ $datos->id }}</td>
            <td>{{ $datos->nombre }}</td>
            <td align="center">{{ strtoupper($datos->user->name) }}</td>
            <td align="center">{{ $datos->dea->nombre }}</td>
            <td align="center">{{ $datos->status }}</td>
        </tr>
    @endforeach
</table>