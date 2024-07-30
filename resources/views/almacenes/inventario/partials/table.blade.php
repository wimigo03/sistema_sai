<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-left p-1"><b>ALMACEN</b></td>
                    <td class="text-left p-1"><b>PARTIDA PRESPUESTARIA</b></td>
                    <td class="text-left p-1"><b>MATERIAL</b></td>
                    <td class="text-right p-1"><b>DISPONIBLE</b></td>
                    <td class="text-center p-1"><b>MEDIDA</b></td>
                    {{--<td class="text-center p-1"><b>ESTADO</b></td>--}}
                    @canany(['almacen.show','almacen.editar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($inventario as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->codigo . ' - ' . $datos->partida_presupuestaria }}</td>
                        <td class="text-left p-1">{{ $datos->material }}</td>
                        <td class="text-right p-1">{{ $datos->saldo_total }}</td>
                        <td class="text-center p-1">{{ $datos->unidad_medida }}</td>
                        {{--<td class="text-left p-1">{{ $datos->direccion }}</td>
                        <td class="text-left p-1">{{ $datos->user != null ? strtoupper($datos->user->nombre_completo) : '' }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorBadgeStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['almacen.show','almacen.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('almacen.show')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="cursor: pointer;">
                                            <a href="{{ route('almacen.show',$datos->id) }}" class="badge-with-padding badge badge-primary">
                                                <i class="fas fa-list fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    &nbsp;
                                    @can('almacen.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('almacen.editar',$datos->id) }}" class="badge-with-padding badge badge-warning">
                                                <i class="fas fa-edit fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                </div>
                            </td>
                        @endcanany--}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
                    <td colspan="12">
                        {{ $inventario->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$inventario->count()}}</strong> registros de
                            <strong>{{$inventario->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
