<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-left p-1"><b>NOMRBE</b></td>
                    <td class="text-left p-1"><b>DIRECCION</b></td>
                    <td class="text-left p-1"><b>ENCARGADO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['almacen.editar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($almacenes as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->direccion }}</td>
                        <td class="text-left p-1">{{ $datos->user != null ? strtoupper($datos->user->nombre_completo) : '' }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorBadgeStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['almacen.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('almacen.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('almacen.editar',$datos->id) }}" class="badge-with-padding badge badge-warning">
                                                <i class="fas fa-edit fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    &nbsp;
                                    @can('almacen.asignar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Asignacion de Areas" style="cursor: pointer;">
                                            <a href="{{ route('almacen.asignar',$datos->id) }}" class="badge-with-padding badge badge-dark">
                                                <i class="fas fa-warehouse fa-fw"></i>
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
                        {{ $almacenes->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$almacenes->count()}}</strong> registros de
                            <strong>{{$almacenes->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
