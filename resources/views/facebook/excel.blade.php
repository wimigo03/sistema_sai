<table>
    <tr>
        <td align="center" colspan="7">
            <b><u>{{ $facebook->titulo }}</u></b>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="7">
            <b>{{ Carbon\Carbon::parse($facebook->fecha)->format('d/m/Y') }}</b>
        </td>
    </tr>
    <tr>
        <td align="center">
            <b>Shares</b>
        </td>
        <td align="center">
            {{ $count_shares }}
        </td>
        <td align="center">
            <b>Likes</b>
        </td>
        <td align="center">
            {{ $count_likes }}
        </td>
        <td align="center">
            <b>Comments</b>
        </td>
        <td align="center">
            {{ $count_comments }}
        </td>
        <td>
            &nbsp;
        </td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th align="center"><b>N°</b></th>
            <th align="center"><b>AREA</b></th>
            {{--<th align="center"><b>CARGO</b></th>--}}
            <th align="center"><b>TIPO</b></th>
            <th align="center"><b>NOMBRE COMPLETO</b></th>
            {{--<th align="center"><b>NRO C.I.</b></th>--}}
            <th align="center"><b>SHARE</b></th>
            <th align="center"><b>LIKE</b></th>
            <th align="center"><b>COMMENT</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($facebook_detalles as $datos)
            <tr>
                <td>{{ $cont++ }}</td>
                <td>{{ $datos->area->nombrearea }}</td>
                {{--<td>{{ $datos->empleado->file_cargo }}</td>--}}
                <td align="center">{{ $datos->empleado->ultimo_tipo_contrato }}</td>
                <td>{{ $datos->empleado->nombres . ' ' . $datos->empleado->ap_pat . ' ' . $datos->empleado->ap_mat }}</td>
                {{--<td align="center">{{ $datos->empleado->ci }}</td>--}}
                <td align="center">{{ $datos->_share == '1' ? '*' : '' }}</td>
                <td align="center">{{ $datos->_like == '1' ? '*' : '' }}</td>
                <td align="center">{{ $datos->_comment == '1' ? '*' : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
