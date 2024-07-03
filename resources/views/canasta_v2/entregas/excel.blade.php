<table>
    <tr>
        <td colspan="9" align="center">
            <b>
                {{ $paquete_barrio->paquete->numero }} ENTREGA
                /
                {{ $paquete_barrio->periodos }} ({{ $paquete_barrio->paquete->gestion }})
                /
                {{ $paquete_barrio->distrito->nombre }}
                -
                {{ $paquete_barrio->barrio->nombre }}
            </b>
        </td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <td><b>N°</b></td>
            <td><b>NOMBRES</b></td>
            <td><b>APELLIDO PATERNO</b></td>
            <td><b>APELLIDO MATERNO</b></td>
            <td><b>N° CARNET</b></td>
            <td align="center"><b>FECHA NAC.</b></td>
            <td align="center"><b>EDAD</b></td>
            <td align="center"><b>SEXO</b></td>
            <td align="center"><b>ESTADO</b></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($entregas as $datos)
            <tr>
                <td>{{ $cont++ }}</td>
                <td>{{ $datos->nombres }}</td>
                <td>{{ $datos->ap }}</td>
                <td>{{ $datos->am }}</td>
                <td>{{ $datos->ci . ' ' . $datos->expedido }}</td>
                <td align="center">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->format('d/m/Y') : '' }}</td>
                <td align="center">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->age : '' }}</td>
                <td align="center">{{ $datos->sexo }}</td>
                <td align="center">{{ $datos->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
