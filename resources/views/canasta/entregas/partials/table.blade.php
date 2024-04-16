<div class="body body-table">
    <div class="form-group row">
        <div class="col-md-12 table-responsive">
            <table class="table display table-bordered responsive" style="width:100%;">
                <thead>
                    <tr class="font-verdana-sm">
                        <td class="text-center p-1"><b>COD_ID</b></td>
                        <td class="text-center p-1"><b>REGISTRO</b></td>
                        <td class="text-left p-1"><b>NRO. C.I.</b></td>
                        <td class="text-center p-1"><b>ESTADO</b></td>
                        <td class="text-center p-1"><b>IMPRESION</b></td>
                        <td class="text-center p-1"><b>CODIGO</b></td>
                        <td class="text-left p-1"><b>BENEFICIARIO</b></td>
                        <td class="text-left p-1"><b>USUARIO</b></td>
                        <td class="text-left p-1"><b>BARRIO</b></td>
                        <td class="text-left p-1"><b>BRIGADISTA</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entregas as $datos)
                        <tr class="font-verdana-sm">
                            <td class="text-center p-1">{{ $datos->idEntrega }}</td>
                            <td class="text-center p-1">
                                <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->_registrado != null ? \Carbon\Carbon::parse($datos->_registrado)->format('H:i:s') : '#' }}" style="cursor: pointer;">
                                    {{ $datos->_registrado != null ? \Carbon\Carbon::parse($datos->_registrado)->format('d/m/Y') : '#' }}
                                </span>
                            </td>
                            <td class="text-left p-1">{{ $datos->ci }}</td>
                            <td class="text-center p-1">{{ $datos->status }}</td>
                            <td class="text-center p-1">{{ $datos->impresion }}</td>
                            <td class="text-center p-1">{{ $datos->codigo }}</td>
                            <td class="text-left p-1">{{ $datos->usuario->nombre_completo }}</td>
                            <td class="text-left p-1">{{ $datos->admin->nombre_completo }}</td>
                            <td class="text-left p-1">{{ $datos->barrio != null ? $datos->barrio->barrio : '#' }}</td>
                            <td class="text-left p-1">{{ $datos->brigadista != null ? $datos->brigadista->nombre_brigadista : '#' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-verdana-11">
                        <td colspan="12">
                            {{ $entregas->appends(Request::all())->links() }}
                            <p class="text-muted">Mostrando
                                <strong>{{$entregas->count()}}</strong> registros de
                                <strong>{{$entregas->total()}}</strong> totales
                            </p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>