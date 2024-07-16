<div class="form-group row font-roboto-12">
    <div class="col-md-12 pr-1 pl-1">
        <table class="table display table-striped table-bordered hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-roboto-10">
                    <td class="text-center p-1"><b>NRO.</b></td>
                    <td class="text-center p-1"><b>TIPO</b></td>
                    <td class="text-justify p-1"><b>SOLICITADO POR</b></td>
                    <td class="text-justify p-1"><b>DESTINO</b></td>
                    <td class="text-justify p-1"><b>DIRIGIDO A</b></td>
                    <td class="text-justify p-1"><b>REFERENCIA</b></td>
                    <td class="text-center p-1"><b>FECHA</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    {{--@canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])--}}
                        <td class="text-center p-1"><i class="fa fa-bars fa-fw"></i></td>
                    {{--@endcanany--}}
                </tr>
            </thead>
            <tbody>
                @foreach ($controles_internos as $datos)
                    <tr class="font-roboto-10">
                        <td class="text-center p-1">{{ $datos->nro }}</td>
                        <td class="text-center p-1">{{ $datos->tipo->nombretipo }}</td>
                        <td class="text-justify p-1">{{ $datos->solicitante }}</td>
                        <td class="text-justify p-1">
                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->area_dirigido }}" style="cursor: pointer;">
                                {{ $datos->area_dirigido_corto }}
                            </span>
                        </td>
                        <td class="text-justify p-1">{{ $datos->dirigido }}</td>
                        <td class="text-justify p-1">{{ $datos->referencia }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        {{--@canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])--}}
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    {{--@can('canasta.beneficiarios.show')--}}
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Modificar">
                                            <a href="{{ route('control.interno.editar', $datos->id) }}" class="badge-with-padding badge badge-secondary">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </span>
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label=".docx">
                                            <a href="{{ route('control.interno.descargar.word', $datos->id) }}" class="badge-with-padding badge badge-primary">
                                                <i class="fa fa-file-word fa-fw"></i>
                                            </a>
                                        </span>
                                        @can('archivos.documentacion')
                                            @if ($datos->idarchivo != null)
                                                <span class="tts:left tts-slideIn tts-custom" aria-label=".pdf">
                                                    <a href="{{ route('archivos.documentacion', $datos->idarchivo) }}" class="badge-with-padding badge badge-danger" target="_blank">
                                                        <i class="fa fa-file-pdf fa-fw"></i>
                                                    </a>
                                                </span>
                                            @else
                                                <span class="tts:left tts-slideIn tts-custom" aria-label=".pdf no encontrado">
                                                    <a href="#" class="badge-with-padding badge badge-danger">
                                                        <i class="fa fa-file-pdf fa-fw"></i>
                                                    </a>
                                                </span>
                                            @endif
                                        @endcan
                                    {{--@endcan--}}
                                </div>
                            </td>
                        {{--@endcanany--}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
                    <td colspan="12">
                        {{ $controles_internos->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{ $controles_internos->count() }}</strong> registros de
                            <strong>{{ $controles_internos->total() }}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
