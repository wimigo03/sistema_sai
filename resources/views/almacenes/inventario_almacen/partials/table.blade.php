<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr class="font-roboto-13">
                    <td class="text-left p-2 text-nowrap"><b>COD.</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ALMACEN</b></td>
                    <td class="text-center p-2 text-nowrap"><b>CAT. PROG.</b></td>
                    <td class="text-left p-2 text-nowrap" style="width: 450px; max-width: 450px; white-space: normal;"><b>PARTIDA PRESUPUESTARIA</b></td>
                    <td class="text-left p-2 text-nowrap" style="width: 450px; max-width: 450px; white-space: normal;"><b>PRODUCTO</b></td>
                    <td class="text-center p-2 text-nowrap"><b>MEDIDA</b></td>
                    <td class="text-right p-2 text-nowrap"><b>ACTUAL</b></td>
                    <td class="text-right p-2 text-nowrap"><b>RESERVA</b></td>
                    <td class="text-right p-2 text-nowrap"><b>TOTAL</b></td>
                    @canany(['inventario.almacen.index'])
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-bars fa-fw"></i></b>
                        </td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($inventarios_almacens as $datos)
                    <tr class="font-roboto-13">
                        <td class="text-left p-2 text-nowrap">{{ $datos->id }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->almacen->nombre }}</td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="tts:right tts-slideIn tts-custom mr-1" aria-label="{{ $datos->categoriaProgramatica->nombre }}" style="cursor: pointer;">
                                {{ $datos->categoriaProgramatica->codigo }}
                            </span>
                        </td>
                        <td class="text-left p-2" style="width: 450px; max-width: 450px; white-space: normal;">
                            {{ $datos->partidaPresupuestaria->codigo . ' - ' . $datos->partidaPresupuestaria->nombre }}
                        </td>
                        <td class="text-left p-2" style="width: 450px; max-width: 450px; white-space: normal;">
                            {{ $datos->producto->codigo . ' - ' . $datos->producto->nombre }}
                        </td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->producto->unidad_medida->nombre }}</td>
                        <td class="text-right p-2 text-nowrap">{{ number_format($datos->stock_actual,2,'.',',') }}</td>
                        <td class="text-right p-2 text-nowrap">{{ number_format($datos->stock_reservado,2,'.',',') }}</td>
                        <td class="text-right p-2 text-nowrap">{{ number_format($datos->stock_actual + $datos->stock_reservado,2,'.',',') }}</td>
                        @canany(['inventario.almacen.index'])
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center">
                                    @can('inventario.almacen.index')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Ir a detalle" style="cursor: pointer;">
                                            <a href="{{ route('movimiento.inventario.show',$datos->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye fa-fw"></i>
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
                <tr class="font-roboto-14">
                    <td colspan="12">
                        {{ $inventarios_almacens->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$inventarios_almacens->count()}}</strong> registros de
                            <strong>{{$inventarios_almacens->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
