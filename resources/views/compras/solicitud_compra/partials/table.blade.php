<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>N° SOL.</b></td>
                    <td class="text-center p-1"><b>AREA</b></td>
                    <td class="text-center p-1"><b>SOLICITANTE</b></td>
                    {{--<td class="text-center p-1"><b>APROB./RECH. POR</b></td>--}}
                    <td class="text-center p-1"><b>N° C.INT.</b></td>
                    <td class="text-center p-1"><b>REGISTRO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['solicitud.compra.show','solicitud.compra.editar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($solicitudes_compras as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-center p-1">{{ $datos->codigo }}</td>
                        <td class="text-center p-1">{{ $datos->area->nombrearea }}</td>
                        <td class="text-center p-1">{{ strtoupper($datos->solicitante->name) }}</td>
                        {{--<td class="text-center p-1">{{ strtoupper($datos->aprobante != null ? $datos->aprobante->name : '-') }}</td>--}}
                        <td class="text-center p-1">{{ $datos->c_interno }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha_registro)->format('d/m/Y') }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['solicitud.compra.show','solicitud.compra.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('solicitud.compra.show')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="cursor: pointer;">
                                            <a href="{{ route('solicitud.compra.show',$datos->id) }}" class="badge-with-padding badge badge-primary">
                                                <i class="fas fa-paper-plane fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
                    <td colspan="12">
                        {{ $solicitudes_compras->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$solicitudes_compras->count()}}</strong> registros de
                            <strong>{{$solicitudes_compras->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
