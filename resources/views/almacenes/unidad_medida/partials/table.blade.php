<div class="row mb-3 font-roboto-14">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr>
                    <td class="text-center p-2 text-nowrap"><b>TIPO</b></td>
                    <td class="text-center p-2 text-nowrap"><b>NOMBRE</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ALIAS</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                    @canany(['unidad.medida.habilitar','unidad.medida.editar'])
                        <td class="text-center p-2 text-nowrap"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($unidades as $datos)
                    <tr>
                        <td class="text-center p-2 text-nowrap">{{ $datos->tipos }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->nombre }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->alias }}</td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['unidad.medida.habilitar','unidad.medida.editar'])
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center">
                                    @can('unidad.medida.habilitar')
                                        @if($datos->status == "HABILITADO")
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar" style="cursor: pointer;">
                                                <a href="{{ route('unidad.medida.deshabilitar',$datos->id) }}" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                                <a href="{{ route('unidad.medida.habilitar',$datos->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan
                                    &nbsp;
                                    @can('unidad.medida.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('unidad.medida.editar',$datos->id) }}" class="btn btn-sm btn-secondary">
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
                <tr class="font-roboto-14">
                    <td colspan="12">
                        {{ $unidades->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$unidades->count()}}</strong> registros de
                            <strong>{{$unidades->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
