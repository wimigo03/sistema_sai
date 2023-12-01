<table>
    <tr>
        <td><b>CODIGO</b></td>
        <td><b>NOMBRES</b></td>
        <td><b>AP. PATERNO</b></td>
        <td><b>AP. MATERNO</b></td>
        <td><b>NRO CARNET</b></td>
        <td align="center"><b>NATALICIO</b></td>
        <td align="center"><b>EDAD</b></td>
        <td align="center"><b>SEXO</b></td>
        <td align="center"><b>DISTRITO</b></td>
        <td><b>BARRIO</b></td>
        <td align="center"><b>ESTADO</b></td>
    </tr>
    @foreach ($beneficiarios as $datos)
        <tr>
            <td>{{ $datos->idUsuario }}</td>
            <td>{{ $datos->nombres }}</td>
            <td>{{ $datos->ap }}</td>
            <td>{{ $datos->am }}</td>
            <td>{{ $datos->ci . ' - ' . $datos->expedido }}</td>
            <td align="center">{{ $datos->fechaNac }}</td>
            <td align="center">{{ $datos->edad }}</td>
            <td align="center">{{ $datos->sexo }}</td>
            <td align="center">{{ $datos->barrios->distrito }}</td>
            <td>{{ $datos->barrios->barrio }}</td>
            <td align="center">{{ $datos->estado }}</td>
        </tr>
    @endforeach
</table>