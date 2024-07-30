<div class="form-group row abs-center">
    <div class="col-md-9 pr-1 pl-1 table-responsive">
        <table class="table display table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-left p-1"><b>CODIGO</b></td>
                    <td class="text-left p-1"><b>CATEGORIA PROGRAMATICA</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['categoria.programatica.habilitar','categoria.programatica.editar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias_programaticas as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->codigo }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['categoria.programatica.habilitar','categoria.programatica.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('categoria.programatica.habilitar')
                                        @if($datos->status == "HABILITADO")
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar" style="cursor: pointer;">
                                                <a href="{{ route('categoria.programatica.deshabilitar',$datos->id) }}" class="badge-with-padding badge badge-danger">
                                                    <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                                <a href="{{ route('categoria.programatica.habilitar',$datos->id) }}" class="badge-with-padding badge badge-success">
                                                    <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan
                                    &nbsp;
                                    @can('categoria.programatica.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('categoria.programatica.editar',$datos->id) }}" class="badge-with-padding badge badge-warning">
                                                <i class="fas fa-edit fa-fw"></i>
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
