<table>
    <tr>
        <td align="center" rowspan="2"><b>CODIGO</b></td>
        <td rowspan="2"><b>TIPO</b></td>
        <td rowspan="2"><b>NOMBRE</b></td>
        <td rowspan="2"><b>DISTRITO</b></td>
        <td align="center" rowspan="2"><b>ESTADO</b></td>
        <td align="center" colspan="4"><b>BENEFICIARIOS</b></td>
    </tr>
    <tr>
        <td align="center"><b>HABILITADOS</b></td>
        <td align="center"><b>BAJAS</b></td>
        <td align="center"><b>FALLECIDOS</b></td>
        <td align="center"><b>PENDIENTES</b></td>
    </tr>
    @foreach ($barrios as $datos)
        <tr>
            <td align="center">{{ $datos->id }}</td>
            <td>{{ $datos->tipo_b }}</td>
            <td>{{ $datos->nombre }}</td>
            <td>{{ $datos->distrito->nombre }}</td>
            <td align="center">{{ $datos->status }}</td>
            <td align="center">{{ $datos->beneficiariosA()->count() }}</td>
            <td align="center">{{ $datos->beneficiariosB()->count() }}</td>
            <td align="center">{{ $datos->beneficiariosF()->count() }}</td>
            <td align="center">{{ $datos->beneficiariosX()->count() }}</td>
        </tr>
    @endforeach
</table>
