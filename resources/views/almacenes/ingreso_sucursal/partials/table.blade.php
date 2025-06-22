<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr class="font-roboto-13">
                    <td class="text-center p-2 text-nowrap"><b>COD. ING.</b></td>
                    <td class="text-center p-2 text-nowrap"><b>SUCURSAL</b></td>
                    <td class="text-left p-2 text-nowrap"><b>PROVEEDOR</b></td>
                    <td class="text-left p-2 text-nowrap"><b>SOLICITANTE</b></td>
                    <td class="text-center p-2 text-nowrap"><b>N° PREV</b></td>
                    <td class="text-center p-2 text-nowrap"><b>N° O.C.</b></td>
                    <td class="text-center p-2 text-nowrap"><b>N° SOL.</b></td>
                    <td class="text-center p-2 text-nowrap"><b>REGISTRO</b></td>
                    <td class="text-center p-2 text-nowrap"><b>INGRESO</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                    @canany(['ingreso.sucursal.show','ingreso.sucursal.pdf','ingreso.sucursal.editar'])
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-bars fa-fw"></i></b>
                        </td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos_almacenes as $datos)
                    <tr class="font-roboto-13">
                        <td class="text-center p-2 text-nowrap">{{ $datos->codigo }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->almacen->nombre }}</td>
                        <td class="text-left p-2 text-nowrap">{{ $datos->proveedor != null ? $datos->proveedor->nombre : '' }}</td>
                        <td class="text-left p-2 text-nowrap" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                            {{ $datos->area->nombrearea }}
                        </td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->n_preventivo }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->n_orden_compra }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->n_solicitud }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->created_at != null ? \Carbon\Carbon::parse($datos->created_at)->format('d-m-Y') : '' }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->fecha_ingreso != null ? \Carbon\Carbon::parse($datos->fecha_ingreso)->format('d-m-Y') : '' }}</td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="{{ $datos->colorBadgeStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['ingreso.sucursal.show','ingreso.sucursal.pdf','ingreso.sucursal.editar'])
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center">
                                    @can('ingreso.sucursal.pdf')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Pdf" style="cursor: pointer;">
                                            <a href="{{ route('ingreso.sucursal.pdf',$datos->id) }}" target="_blank" class="btn btn-sm btn-outline-warning text-dark">
                                                <i class="fas fa-print fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('ingreso.sucursal.show')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Ir a detalle" style="cursor: pointer;">
                                            <a href="{{ route('ingreso.sucursal.show',$datos->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('ingreso.sucursal.editar')
                                        @if ($datos->status == 'PENDIENTE')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                                <a href="{{ route('ingreso.sucursal.editar',$datos->id) }}" class="btn btn-sm btn-warning">
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
                        {{ $ingresos_almacenes->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$ingresos_almacenes->count()}}</strong> registros de
                            <strong>{{$ingresos_almacenes->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
