<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr class="font-roboto-13">
                    <td class="text-center p-2 text-nowrap"><b>SUCURSAL</b></td>
                    <td class="text-center p-2 text-nowrap"><b>GESTION</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                    @canany(['balance.inicial.show','balance.inicial.pdf','balance.inicial.editar'])
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-bars fa-fw"></i></b>
                        </td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($balances_iniciales as $datos)
                    <tr class="font-roboto-13">
                        <td class="text-center p-2 text-nowrap">{{ $datos->almacen->nombre }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->gestion }}</td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="{{ $datos->ingreso_almacen->colorBadgeStatus }}">
                                {{ $datos->ingreso_almacen->status }}
                            </span>
                        </td>
                        @canany(['balance.inicial.show','balance.inicial.pdf','balance.inicial.editar'])
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center">
                                    @can('balance.inicial.pdf')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Pdf" style="cursor: pointer;">
                                            <a href="{{ route('balance.inicial.pdf',$datos->ingreso_almacen_id) }}" target="_blank" class="btn btn-sm btn-outline-warning text-dark">
                                                <i class="fas fa-print fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('balance.inicial.show')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Ir a detalle" style="cursor: pointer;">
                                            <a href="{{ route('balance.inicial.show',$datos->ingreso_almacen_id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('balance.inicial.editar')
                                        @if ($datos->ingreso_almacen->status == 'PENDIENTE')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                                <a href="{{ route('balance.inicial.editar',$datos->ingreso_almacen_id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                                <span class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-edit fa-fw"></i>
                                                </span>
                                            </span>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11" class="font-roboto-14">
                        {{ $balances_iniciales->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$balances_iniciales->count()}}</strong> registros de
                            <strong>{{$balances_iniciales->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
