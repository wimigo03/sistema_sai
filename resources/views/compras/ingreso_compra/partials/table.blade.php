<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-left p-1"><b>CODIGO</b></td>
                    <td class="text-left p-1"><b>AREA SOLICITANTE</b></td>
                    <td class="text-left p-1"><b>ALMACEN</b></td>
                    <td class="text-left p-1"><b>PROVEEDOR</b></td>
                    <td class="text-left p-1"><b>NRO. O.C.</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['ingreso.compra.show'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos_compras as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->codigo }}</td>
                        <td class="text-left p-1">{{ $datos->area->nombrearea }}</td>
                        <td class="text-left p-1">{{ $datos->almacen->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->proveedor->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->orden_compra->codigo }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorBadgeStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['ingreso.compra.show'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('ingreso.compra.show')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="cursor: pointer;">
                                            <a href="{{ route('ingreso.compra.show',$datos->id) }}" class="badge-with-padding badge badge-primary">
                                                <i class="fas fa-list fa-fw"></i>
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
                        {{ $ingresos_compras->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$ingresos_compras->count()}}</strong> registros de
                            <strong>{{$ingresos_compras->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
