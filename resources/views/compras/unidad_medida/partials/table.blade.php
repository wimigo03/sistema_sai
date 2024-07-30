<div class="form-group row abs-center">
    <div class="col-md-10 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>TIPO</b></td>
                    <td class="text-center p-1"><b>NOMBRE</b></td>
                    <td class="text-center p-1"><b>ALIAS</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['unidad.medida.habilitar','unidad.medida.editar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($unidades as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-center p-1">{{ $datos->tipos }}</td>
                        <td class="text-center p-1">{{ $datos->nombre }}</td>
                        <td class="text-center p-1">{{ $datos->alias }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['unidad.medida.habilitar','unidad.medida.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('unidad.medida.habilitar')
                                        @if($datos->status == "HABILITADO")
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar" style="cursor: pointer;">
                                                <a href="{{ route('unidad.medida.deshabilitar',$datos->id) }}" class="badge-with-padding badge badge-danger">
                                                    <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                                <a href="{{ route('unidad.medida.habilitar',$datos->id) }}" class="badge-with-padding badge badge-success">
                                                    <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan
                                    &nbsp;
                                    @can('unidad.medida.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('unidad.medida.editar',$datos->id) }}" class="badge-with-padding badge badge-warning">
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
