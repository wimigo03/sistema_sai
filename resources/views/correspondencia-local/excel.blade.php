<table>
    <thead>
        <tr>
            <td align="left"><b>NRO</b></td>
            <td align="left"><b>NOMBRE COMPLETO</b></td>
            <td align="left"><b>UNIDAD</b></td>
            <td align="left"><b>ASUNTO</b></td>
            <td align="center"><b>FECHA</b></td>
            <td align="center"><b>CODIGO</b></td>
            <td align="center"><b>H.RUTA</b></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($recepciones as $datos)
            <tr>
                <td align="left">{{ $cont++ }}</td>
                <td align="left">{{ $datos->remitente_completo }}</td>
                <td align="left">{{ $datos->unidad_remitente }}</td>
                <td align="left">{{ $datos->asunto }}</td>
                <td align="center">{{ $datos->fecha_recepcion }}</td>
                <td align="center">{{ $datos->n_oficio }}</td>
                <td align="center">{{ $datos->observaciones }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
