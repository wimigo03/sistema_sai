<div class="form-group row font-roboto-12">
    <div class="col-md-12 pr-1 pl-1">
        <table class="table display table-striped table-bordered hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-roboto-10">
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    <td class="text-center p-1"><b>CODIGO/SERIE</b></td>
                    <td class="text-left p-1"><b>PROCEDENCIA</b></td>
                    <td class="text-left p-1"><b>FUNCIONARIO</b></td>
                    <td class="text-left p-1"><b>CLASIFICACION</b></td>
                    <td class="text-center p-1"><b>RECEPCION</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['mantenimiento.index'])
                        <td class="text-center p-1"><i class="fa fa-bars fa-fw"></i></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($mantenimiento_detalles as $datos)
                    <tr class="font-roboto-10">
                        <td class="text-center p-1">{{ $datos->mantenimiento->codigo }}</td>
                        <td class="text-center p-1">{{ $datos->codigo_serie }}</td>
                        <td class="text-justify p-1">
                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->area->nombrearea }}" style="cursor: pointer;">
                                {{ $datos->area_corta }}
                            </span>
                        </td>
                        <td class="text-justify p-1">{{ $datos->funcionario->nombres }}</td>
                        <td class="text-left p-1">{{ $datos->clasificacion_equipo }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->mantenimiento->fecha_recepcion)->format('d/m/Y H:i') }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->color_status }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['mantenimientos.index'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                        <a href="{{ route('mantenimientos.show', $datos->mantenimiento_id) }}" class="badge-with-padding badge badge-primary">
                                            <i class="fas fa-external-link-alt fa-fw"></i>
                                        </a>
                                    </span>
                                    {{-- <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Modificar">
                                        <a href="{{ route('mantenimientos.editar', $datos->mantenimiento_id) }}" class="badge-with-padding badge badge-warning">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    </span>
                                    <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Exportar">
                                        <a href="{{ route('mantenimientos.pdf', $datos->mantenimiento_id) }}" class="badge-with-padding badge badge-danger">
                                            <i class="fa fa-file-pdf fa-fw"></i>
                                        </a>
                                    </span> --}}
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
                    <td colspan="12">
                        {{ $mantenimiento_detalles->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{ $mantenimiento_detalles->count() }}</strong> registros de
                            <strong>{{ $mantenimiento_detalles->total() }}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
