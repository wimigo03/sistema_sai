<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr>
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
                    <tr>
                        <td class="text-center p-2 text-nowrap">{{ $datos->codigo }}</td>
                        <td class="text-justify p-2 text-nowrap">{{ $datos->nombre }}</td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['categoria.programatica.habilitar','categoria.programatica.editar','area.categoria.index'])
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center gap-1">
                                    @can('categoria.programatica.habilitar')
                                        @if($datos->status == "HABILITADO")
                                            <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Deshabilitar" style="cursor: pointer;">
                                                <a href="{{ route('categoria.programatica.deshabilitar',$datos->id) }}" class="badge badge-danger p-2">
                                                    <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Habilitar" style="cursor: pointer;">
                                                <a href="{{ route('categoria.programatica.habilitar',$datos->id) }}" class="badge badge-success p-2">
                                                    <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan
                                    @can('categoria.programatica.editar')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('categoria.programatica.editar',$datos->id) }}" class="badge badge-warning p-2">
                                                <i class="fas fa-edit fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('area.categoria.index')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Habilitar Areas Por Categoria" style="cursor: pointer;">
                                            <a href="{{ route('area.categoria.index',$datos->id) }}" class="badge badge-primary p-2">
                                                <i class="fa-solid fa-layer-group fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('categoria.presupuestaria.index')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Habilitar Partidas Por Categoria" style="cursor: pointer;">
                                            <a href="{{ route('categoria.presupuestaria.index',$datos->id) }}" class=" badge badge-dark p-2">
                                                <i class="fa-solid fa-list-ul fa-fw"></i>
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
