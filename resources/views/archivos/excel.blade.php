<table>
    <tr>
        <td align="center"><b>N°</b></td>
        <td align="center"><b>GESTION</b></td>
        <td align="center"><b>REC./ENV.</b></td>
        <td align="center"><b>N. DOC.</b></td>
        <td align="center"><b>REFERENCIA</b></td>
        <td align="center"><b>TIPO</b></td>
    </tr>
    @foreach ($archivos as $datos)
        <tr>
            <td align="center">{{ $cont++ }}</td>
            <td align="center">{{ $datos->gestion }}</td>
            <td align="center">{{ $datos->fecha }}</td>
            <td align="center">{{ $datos->nombrearchivo }}</td>
            <td>{{ $datos->referencia }}</td>
            <td align="center">{{ $datos->tipo->nombretipo }}</td>
        </tr>
    @endforeach
</table>
