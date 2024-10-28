<div class="form-group row font-roboto-12">
    <div class="col-md-12 pr-1 pl-1">
        <table class="table display table-striped table-bordered hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-roboto-10">
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    <td class="text-center p-1"><b>CODIGO/SERIE</b></td>
                    <td class="text-center p-1"><b>PROCEDENCIA</b></td>
                    <td class="text-center p-1"><b>ENCARGADO</b></td>
                    <td class="text-center p-1"><b>CLASIFICACION</b></td>
                    <td class="text-center p-1"><b>F/REC.</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    <td class="text-center p-1"><b>USUARIO</b></td>
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
                        <td class="text-center p-1">
                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->area->nombrearea }}" style="cursor: pointer;">
                                {{ $datos->area_corta }}
                            </span>
                        </td>
                        <td class="text-center p-1">{{ $datos->funcionario->nombres }}</td>
                        <td class="text-center p-1">{{ $datos->clasificacion_equipo }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha_r)->format('d/m/Y') }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->mantenimiento->color_status_alias }}">
                                {{ $datos->mantenimiento->status_alias }}
                            </span>
                            <span class="{{ $datos->color_status }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        <td class="text-center p-1">{{ $datos->user_asignado != null ? strtoupper($datos->user_asignado->name) : '' }}</td>
                        @canany(['mantenimientos.index'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                        <a href="{{ route('mantenimientos.show', $datos->mantenimiento_id) }}" class="badge-with-padding badge badge-primary">
                                            <i class="fas fa-external-link-alt fa-fw"></i>
                                        </a>
                                    </span>
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
