<div class="form-group row abs-center">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-center p-1">N°</th>
                    <th class="text-center p-1">AREA</th>
                    <th class="text-center p-1">CARGO</th>
                    <th class="text-center p-1">CARGO SALARIAL</th>
                    <th class="text-center p-1">HABER BASICO</th>
                    <th class="text-center p-1">CATEGORIA</th>
                    <th class="text-center p-1">N. ADM.</th>
                    <th class="text-center p-1">CLASE</th>
                    <th class="text-center p-1">N. SAL.</th>
                    <th class="text-center p-1">TIPO</th>
                    <th class="text-center p-1">ESTADO</th>
                    @canany(['files.editar'])
                        <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->numfile }}</td>
                        <td class="text-left p-1">{{ $datos->area->nombrearea }}</td>
                        <td class="text-left p-1">{{ $datos->nombrecargo }}</td>
                        <td class="text-left p-1">{{ $datos->cargo }}</td>
                        <td class="text-right p-1">{{ number_format($datos->habbasico,2,'.',',') }}</td>
                        <td class="text-center p-1">{{ $datos->categoria }}</td>
                        <td class="text-center p-1">{{ $datos->niveladm }}</td>
                        <td class="text-center p-1">{{ $datos->clase }}</td>
                        <td class="text-center p-1">{{ $datos->nivelsal }}</td>
                        <td class="text-center p-1">{{ $datos->tipos }}</td>
                        <td class="text-center p-1">
                            @if ($datos->estadofile == '1')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="{{ $datos->empleado_actual }}" style="cursor: pointer;">
                                    <span class="{{ $datos->colorStatus }}">
                                        {{ $datos->status }}
                                    </span>
                                </span>
                            @else
                                <span class="{{ $datos->colorStatus }}">
                                    {{ $datos->status }}
                                </span>
                            @endif

                        </td>
                        @canany(['files.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('files.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('file.editar',$datos->idfile) }}" class="badge-with-padding badge badge-warning">
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
                        {{ $files->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$files->count()}}</strong> registros de
                            <strong>{{$files->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
