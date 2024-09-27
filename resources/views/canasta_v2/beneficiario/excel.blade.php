<table>
    <thead>
        <tr>
            {{--<td align="center"><b>CODIGO</b></td>--}}
            <td><b>N</b></td>
            <td align="center"><b>DISTRITO</b></td>
            <td><b>BARRIO</b></td>
            <td><b>BENEFICIARIO</b></td>
            <td align="center"><b>ESTADO CIVIL</b></td>
            <td align="center"><b>FOTO</b></td>
            <td align="center"><b>CARNET</b></td>
            <td align="center"><b>EXP.</b></td>
            <td align="center"><b>H/M</b></td>
            <td align="center"><b>FECHA DE NAC.</b></td>
            <td align="center"><b>EDAD</b></td>
            <td align="center"><b>INSCRIPCION</b></td>
            <td align="center"><b>OCUPACION</b></td>
            <td><b>DIRECCION</b></td>
            <td align="center"><b>CELULAR</b></td>
            <td align="center"><b>ESTADO</b></td>
            <td align="center"><b>USUARIO</b></td>
            <td align="center"><b>¿ACTUALIZADO?</b></td>
            <td align="center"><b>FECHA</b></td>
            <td align="center"><b>Y</b></td>
            <td align="center"><b>X</b></td>
            <td align="center"><b>ANV.</b></td>
            <td align="center"><b>REV.</b></td>
            <td align="center"><b>¿SE NEGO A DAR INFORMACION?</b></td>
            <td align="center"><b>SEGURO MEDICO</b></td>
             <td align="center"><b>¿ES TITULAR?</b></td>
        </tr>
    </thead>
    <tbody>
        @php
            $num = 1;
        @endphp
        @foreach ($beneficiarios as $datos)
            <tr>
                {{--<td align="center">{{ $datos->id }}</td>--}}
                <td>{{ $num++ }}</td>
                <td align="center">{{ $datos->distrito->nombre }}</td>
                <td>{{ $datos->barrio->nombre }}</td>
                <td>{{ $datos->nombres . ' ' . $datos->ap . ' ' . $datos->am }}</td>
                <td align="center">{{ strtoupper($datos->estado_civil) }}</td>
                <td align="center">{{ $datos->dir_foto != null ? 'SI' : 'NO' }}</td>
                <td align="center">{{ $datos->ci }}</td>
                <td align="center">{{ $datos->expedido }}</td>
                <td align="center">{{ $datos->sexo }}</td>
                <td align="center">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->format('d/m/Y') : '' }}</td>
                <td align="center">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->age : '' }}</td>
                <td align="center">{{ $datos->created_att != null ? \Carbon\Carbon::parse($datos->created_att) : '' }}</td>
                <td align="center">{{ $datos->ocupacion != null ? $datos->ocupacion->ocupacion : '-' }}</td>
                <td>{{ $datos->direccion }}</td>
                <td align="center">{{ $datos->celular }}</td>
                <td align="center">{{ $datos->status }}</td>
                <td align="center">{{ $datos->user_censo != null ? strtoupper($datos->user_censo->nombre_completo) : '-' }}</td>
                <td align="center">{{ $datos->censado == '1' ? 'NO' : 'SI' }}</td>
                <td align="center">{{ $datos->fecha_censo != null ? \Carbon\Carbon::parse($datos->fecha_censo)->format('d/m/Y') : '' }}</td>
                <td align="center">{{ $datos->utmy }}</td>
                <td align="center">{{ $datos->utmx }}</td>
                <td align="center">{{ $datos->file_ci_anverso != null ? 'SI' : 'NO' }}</td>
                <td align="center">{{ $datos->file_ci_reverso != null ? 'SI' : 'NO' }}</td>
                @if ($datos->informacion != null)
                    <td align="center">{{ $datos->informacion == '2' ? 'SI' : 'NO' }}</td>
                @else
                    <td align="center"></td>
                @endif
                <td align="center">{{ $datos->seguros_medicos }}</td>
                <td align="center">{{ $datos->seguro_medico != null ? $datos->titular_seguro : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
