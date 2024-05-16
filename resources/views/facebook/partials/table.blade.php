<div class="form-group row abs-center">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-center p-1">COD.</th>
                    <th class="text-center p-1">FECHA</th>
                    <th class="text-center p-1">TITULO</th>
                    <th class="text-center p-1">ESTADO</th>
                    <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($publicaciones as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-center p-1">{{ $datos->id }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                        <td class="text-left p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a enlace" style="cursor: pointer;">
                                <a href="{{ $datos->publicacion }}" class="text-dark" target="_blank">
                                    {{ $datos->titulo }}
                                </a>
                            </span>
                        </td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['facebook.cargar.datos'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('facebook.cargar.datos')
                                        @if ($datos->estado == '1')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Dehabilitar" style="cursor: pointer;">
                                                <a href="{{ route('facebook.deshabilitar',$datos->id) }}" class="badge-with-padding badge badge-danger">
                                                    <i class="fas fa-arrow-down fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                                <a href="{{ route('facebook.habilitar',$datos->id) }}" class="badge-with-padding badge badge-success">
                                                    <i class="fas fa-arrow-up fa-fw"></i>
                                                </a>
                                            </span>
                                            &nbsp;
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar" style="cursor: pointer;">
                                                <a href="{{ route('facebook.eliminar',$datos->id) }}" class="badge-with-padding badge badge-danger">
                                                    <i class="fas fa-trash fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                        &nbsp;
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Cargar datos" style="cursor: pointer;">
                                            <a href="{{ route('facebook.cargar.datos',$datos->id) }}" class="badge-with-padding badge badge-primary">
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
                        {{ $publicaciones->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$publicaciones->count()}}</strong> registros de
                            <strong>{{$publicaciones->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
