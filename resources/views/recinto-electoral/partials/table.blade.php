<div class="div_detalle mb-4">
    <div class="row mb-3 abs-center">
        <div class="col-12 col-md-6 col-lg-3" style="display: flex; justify-content: flex-end;" id="custom-search">
            <input type="search" id="_detalle_tabla_filter" class="form-control font-roboto-14 border-dark" placeholder="Buscar" aria-controls="detalle_tabla">
        </div>
    </div>
    <div class="row mb-3 abs-center">
        <div class="col-12 table-responsive">
            <table id="detalle_tabla" class="table table-striped table-hover display responsive hover-orange">
                <thead class="bg-dark text-white">
                    <tr class="font-roboto-13">
                        <td class="text-center p-2 text-nowrap"><b>MUNICIPIO</b></td>
                        <td class="text-center p-2 text-nowrap"><b>NOMBRE</b></td>
                        <td class="text-center p-2 text-nowrap"><b>ZONA</b></td>
                        <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                        @can(['recintos.index'])
                            <td class="text-center p-2 text-nowrap">
                                <b><i class="fa-solid fa-bars fa-fw"></i></b>
                            </td>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recintosElectorales as $datos)
                        <tr class="font-roboto-13">
                            <td class="text-center p-2 text-nowrap">{{ $datos->municipio->nombre }}</td>
                            <td class="text-center p-2 text-nowrap">{{ $datos->nombre }}</td>
                            <td class="text-center p-2 text-nowrap">{{ $datos->zone }}</td>
                            <td class="text-center p-2 text-nowrap">
                                <span class="{{ $datos->colorStatus }}">
                                    {{ $datos->status }}
                                </span>
                            </td>
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center">
                                    @can('recintos.index')
                                        @if ($datos->estado == 1)
                                            <a href="{{ route('recintos.show.mesas.electorales',$datos->id) }}" class="btn btn-sm btn-outline-info text-dark mr-2">
                                                <i class="fas fa-landmark fa-fw"></i> Mesas de Sufragio
                                            </a>
                                        @endcan

                                        @if (Auth::user()->id == 102)
                                            @if ($datos->estado == 1)
                                                <a href="{{ route('recintos.deshabilitar',$datos->id) }}" class="btn btn-sm btn-outline-danger text-dark">
                                                    <i class="fas fa-ban fa-fw"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('recintos.habilitar',$datos->id) }}" class="btn btn-sm btn-outline-success text-dark">
                                                    <i class="fas fa-check fa-fw"></i>
                                                </a>
                                            @endif
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                {{--<tfoot>
                    <tr>
                        <td colspan="11" class="font-roboto-14">
                            {{ $salidas_almacenes->appends(Request::all())->links() }}
                            <p class="text- muted">Mostrando
                                <strong>{{$salidas_almacenes->count()}}</strong> registros de
                                <strong>{{$salidas_almacenes->total()}}</strong> totales
                            </p>
                        </td>
                    </tr>
                </tfoot>--}}
            </table>
        </div>
    </div>
</div>
