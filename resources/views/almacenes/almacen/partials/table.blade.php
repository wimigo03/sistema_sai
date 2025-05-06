<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr>
                    <td class="text-left p-2 text-nowrap"><b>NOMRBE</b></td>
                    <td class="text-left p-2 text-nowrap"><b>DIRECCION</b></td>
                    <td class="text-left p-2 text-nowrap"><b>ENCARGADO</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                    @canany(['almacen.editar'])
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-bars"></i></b>
                        </td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($almacenes as $datos)
                    <tr>
                        <td class="text-left p-2 text-nowrap">{{ $datos->nombre }}</td>
                        <td class="text-left p-2 text-nowrap">{{ $datos->direccion }}</td>
                        <td class="text-left p-2 text-nowrap">{{ $datos->user != null ? strtoupper($datos->user->nombre_completo) : '' }}</td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="{{ $datos->colorBadgeStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['almacen.editar'])
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center gap-1">
                                    @can('almacen.editar')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('almacen.editar',$datos->id) }}" class="badge badge-secondary p-2">
                                                <i class="fas fa-edit fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('almacen.asignar')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Areas Permitidas" style="cursor: pointer;">
                                            <a href="{{ route('almacen.asignar',$datos->id) }}" class="badge badge-primary p-2">
                                                <i class="fa-solid fa-house-laptop fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('inventario.inicial.index')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Inventario Inicial" style="cursor: pointer;">
                                            <a href="{{ route('inventario.inicial.index',['almacen_id' => $datos->id]) }}" class="badge badge-dark p-2">
                                                <i class="fa-solid fa-list-alt fa-fw"></i>
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
