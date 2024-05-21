@if (isset($empleados))
    <table>
        <tr>
            <td colspan="7" align="center">
                <b>{{ $fecha_i }} - {{ $fecha_f }}</b>
            </td>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th align="center"><b>N°</b></th>
                <th align="left"><b>AREA</b></th>
                {{--<th align="left"><b>CARGO</b></th>--}}
                <th align="center"><b>TIPO</b></th>
                <th align="left"><b>NOMBRE COMPLETO</b></th>
                {{--<th align="center"><b>NRO CI</b></th>--}}
                <th align="center"><b>SHARES</b></th>
                <th align="center"><b>LIKES</b></th>
                <th align="center"><b>COMMENTS</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $datos)
                <tr>
                    <td align="left">{{ $cont++ }}</td>
                    <td align="left">{{ $datos->empleado->area->nombrearea }}</td>
                    {{--<td align="left">{{ $datos->empleado->cargo_file . ' - ' . $datos->empleado->file_cargo }}</td>--}}
                    <td align="center">{{ $datos->empleado->ultimo_tipo_contrato }}</td>
                    <td align="left">{{ $datos->empleado->nombres . ' ' . $datos->empleado->ap_pat . ' ' . $datos->empleado->ap_mat }}</td>
                    {{--<td align="center">{{ $datos->empleado->ci . ' - ' . $datos->empleado->extension }}</td>--}}
                    <td align="center">{{ $datos->total_shares }}</td>
                    <td align="center">{{ $datos->total_likes }}</td>
                    <td align="center">{{ $datos->total_comments }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
