<table>
    <thead>
        <tr>
            <td align="center"><b>CODIGO</b></td>
            <td><b>NOMBRES</b></td>
            <td><b>APELLIDO PATERNO</b></td>
            <td><b>APELLIDO MATERNO</b></td>
            <td align="center"><b>CI</b></td>
            <td align="center"><b>SEXO</b></td>
            <td align="center"><b>BARRIO</b></td>
            <td><b>DIRECCION</b></td>
            <td align="center"><b>ESTADO</b></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($beneficiarios as $datos)
            <tr>
                <td align="center">{{ $datos->id }}</td>
                <td>{{ $datos->nombres }}</td>
                <td>{{ $datos->ap }}</td>
                <td>{{ $datos->am }}</td>
                <td align="center">{{ $datos->ci . '-' . $datos->expedido }}</td>
                <td align="center">{{ $datos->sexo }}</td>
                <td align="center">{{ $datos->barrio->nombre }}</td>
                <td>{{ $datos->direccion }}</td>
                <td align="center">{{ $datos->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
