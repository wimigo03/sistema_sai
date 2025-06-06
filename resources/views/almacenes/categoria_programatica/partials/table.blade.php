<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr class="font-roboto-14">
                    <td class="text-center p-2 text-nowrap"><b>CODIGO</b></td>
                    <td class="text-center p-2 text-nowrap"><b>CATEGORIA PROGRAMATICA</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                    @canany(['categoria.programatica.habilitar','categoria.programatica.editar','area.categoria.index'])
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-bars fa.fw"></i></b>
                        </td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias_programaticas as $datos)
                    <tr class="font-roboto-14">
                        <td class="text-center p-2 text-nowrap">{{ $datos->codigo }}</td>
                        <td class="text-justify p-2 text-nowrap">{{ $datos->nombre }}</td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['categoria.programatica.habilitar','categoria.programatica.editar'])
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center gap-1">
                                    @can('categoria.programatica.habilitar')
                                        @if($datos->status == "HABILITADO")
                                            <a href="{{ route('categoria.programatica.deshabilitar',$datos->id) }}" class="btn btn-sm btn-danger mr-1">
                                                <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('categoria.programatica.habilitar',$datos->id) }}" class="btn btn-sm btn-success mr-1">
                                                <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                            </a>
                                        @endif
                                    @endcan
                                    @can('categoria.programatica.editar')
                                        <a href="{{ route('categoria.programatica.editar',$datos->id) }}" class="btn btn-sm btn-warning mr-1">
                                            <i class="fas fa-edit fa-fw"></i>
                                        </a>
                                    @endcan
                                    @can('categoria.programatica.create')
                                        <a href="{{ route('categoria.programatica.show',$datos->id) }}" class="btn btn-sm btn-primary mr-1">
                                            <i class="fas fa-eye fa-fw"></i>
                                        </a>
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
                        {{ $categorias_programaticas->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$categorias_programaticas->count()}}</strong> registros de
                            <strong>{{$categorias_programaticas->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
