<table>
    <tr>
        <td colspan="13" align="center">
            <b>
                <u>
                    {{ $paquete->numero }} ENTREGA
                    /
                    @php
                        $periodos = DB::table('paquete_periodo as a')
                                        ->join('periodos as b','b.id','a.id_periodo')
                                        ->where('a.id_paquete',$paquete->id)
                                        ->where('a.estado','1')
                                        ->get();
                    @endphp
                    @foreach ($periodos as $periodo)
                        {{ $periodo->mes }}
                    @endforeach
                    ({{ $paquete->gestion }})
                </u>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            <b>Registrados</b>
        </td>
        <td>
            {{ $paquete->registrados }}
        </td>
        <td>
            <b>Entregados</b>
        </td>
        <td>
            {{ $paquete->entregados }}
        </td>
        <td>
            <b>No entregados</b>
        </td>
        <td>
            {{ $paquete->no_entregados }}
        </td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <td align="center"><b>DISTRITO</b></td>
            <td align="center"><b>BARRIO</b></td>
            <td align="center"><b>LUGAR DE ENTREGA</b></td>
            <td align="center"><b>DIA</b></td>
            <td align="center"><b>FECHA</b></td>
            <td align="center"><b>HORA DE INICIO</b></td>
            <td align="center"><b>HORA FINAL</b></td>
            <td align="center"><b>REG.</b></td>
            <td align="center"><b>NO REG.</b></td>
            <td align="center"><b>HAB.</b></td>
            <td align="center"><b>ENT.</b></td>
            <td align="center"><b>NO ENT.</b></td>
            <td align="center"><b>RESAGADOS</b></td>
            <td align="center"><b>ESTADO</b></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($paquetes_barrios as $datos)
            <tr>
                <td align="center">{{ $datos->distrito->nombre }}</td>
                <td>{{ $datos->barrio->nombre }}</td>
                <td>{{ $datos->lugar_entrega }}</td>
                <td align="center">{{ $datos->fecha_entrega != null ? mb_strtoupper(strftime('%A', strtotime($datos->fecha_entrega)), 'UTF-8') : '' }}</td>
                <td align="center">{{ $datos->fecha_entrega != null ? \Carbon\Carbon::parse($datos->fecha_entrega)->format('d/m/Y') : '' }}</td>
                <td align="center">{{ $datos->hora_inicio }}</td>
                <td align="center">{{ $datos->hora_final }}</td>
                <td align="center">{{ $datos->total_registrados }}</td>
                <td align="center">{{ $datos->total_no_registrados }}</td>
                <td align="center">{{ $datos->total_habilitados }}</td>
                <td align="center">{{ $datos->total_entregados }}</td>
                <td align="center">{{ $datos->total_no_entregados }}</td>
                <td align="center">{{ $datos->total_resagados }}</td>
                <td align="center">{{ $datos->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
