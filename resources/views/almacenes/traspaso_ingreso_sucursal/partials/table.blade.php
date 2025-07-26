<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr class="font-roboto-13">
                    <td class="text-center p-2 text-nowrap"><b>COD.</b></td>
                    <td class="text-center p-2 text-nowrap"><b>COD. ING.</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ORIGEN</b></td>
                    <td class="text-center p-2 text-nowrap"><b>DESTINO</b></td>
                    <td class="text-center p-2 text-nowrap"><b>TRASPASO</b></td>
                    <td class="text-center p-2 text-nowrap"><b>SALIDA</b></td>
                    <td class="text-center p-2 text-nowrap"><b>INGRESO</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                    @canany(['traspaso.sucursal.show','traspaso.sucursal.pdf'])
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-bars fa-fw"></i></b>
                        </td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($traspasos_almacenes as $datos)
                    <tr class="font-roboto-13">
                        <td class="text-center p-2 text-nowrap">{{ $datos->codigo }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->ingreso_almacen->codigo }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->almacen_origen->nombre }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->almacen_destino->nombre }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->fecha_traspaso != null ? \Carbon\Carbon::parse($datos->fecha_traspaso)->format('d-m-Y') : '' }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->fecha_salida != null ? \Carbon\Carbon::parse($datos->fecha_salida)->format('d-m-Y') : '' }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->fecha_ingreso != null ? \Carbon\Carbon::parse($datos->fecha_ingreso)->format('d-m-Y') : '' }}</td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="{{ $datos->colorBadgeStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['traspaso.sucursal.show','traspaso.sucursal.pdf'])
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center">
                                    @can('traspaso.sucursal.pdf')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Pdf" style="cursor: pointer;">
                                            <a href="{{ route('traspaso.sucursal.pdf',$datos->id) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-file-pdf fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('traspaso.sucursal.show')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Ir a detalle" style="cursor: pointer;">
                                            <a href="{{ route('traspaso.sucursal.show',$datos->id) }}" class="btn btn-sm btn-primary">
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
                <tr>
                    <td colspan="11" class="font-roboto-14">
                        {{ $traspasos_almacenes->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$traspasos_almacenes->count()}}</strong> registros de
                            <strong>{{$traspasos_almacenes->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
