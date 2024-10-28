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
            <td align="right"><b>REG.</b></td>
            <td align="right"><b>ENT.</b></td>
            <td align="right"><b>NO ENT.</b></td>
            <td align="right"><b>RESAGADOS</b></td>
            <td align="right"><b>TOTAL</b></td>
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
                <td align="right">{{ $datos->total_registrados }}</td>
                <td align="right">{{ $datos->total_entregados }}</td>
                <td align="right">{{ $datos->total_no_entregados }}</td>
                <td align="right">{{ $datos->total_resagados }}</td>
                <td align="right">{{ $datos->total_canastas }}</td>
                <td align="center">{{ $datos->status }}</td>
            </tr>
        @endforeach
        {{-- <tr>
            <td align="center" colspan="7">
                <b>TOTAL</b>
            </td>
            <td align="right">
                <b>{{ $paquete->registrados }}</b>
            </td>
            <td align="right">
                <b>{{ $paquete->entregados }}</b>
            </td>
            <td align="right">
                <b>{{ $paquete->no_entregados }}</b>
            </td>
            <td align="right">
               <b>{{ $paquete->resagados }}</b>
            </td>
            <td align="right">
                <b>{{ $paquete->total_canastas }}</b>
            </td>
        </tr> --}}
    </tbody>
</table>
