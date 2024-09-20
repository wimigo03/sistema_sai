<div class="form-group row font-roboto-12">
    <div class="col-md-12 pr-1 pl-1">
        <table class="table display table-striped table-bordered hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-roboto-10">
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    <td class="text-center p-1"><b>COD_ACTIVO</b></td>
                    <td class="text-center p-1"><b>PROCEDENCIA</b></td>
                    <td class="text-center p-1"><b>EMPLEADO</b></td>
                    <td class="text-center p-1"><b>CLASIFICACION</b></td>
                    <td class="text-center p-1"><b>RECEPCION</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    {{--@canany(['control.interno.index'])
                        <td class="text-center p-1"><i class="fa fa-bars fa-fw"></i></td>
                    @endcanany--}}
                </tr>
            </thead>
            <tbody>
                @foreach ($mantenimientos as $datos)
                    <tr class="font-roboto-10">
                        <td class="text-center p-1">{{ $datos->id }}</td>
                        <td class="text-center p-1">{{ $datos->codigo }}</td>
                        <td class="text-justify p-1">
                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->area->nombrearea }}" style="cursor: pointer;">
                                {{ $datos->area_corta }}
                            </span>
                        </td>
                        <td class="text-justify p-1">{{ $datos->funcionario->nombres }}</td>
                        <td class="text-center p-1">{{ $datos->clasificacion_equipo }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha_recepcion)->format('d/m/Y H:i') }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->color_status }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        {{--@canany(['control.interno.index'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Modificar">
                                        <a href="{{ route('control.interno.editar', $datos->id) }}" class="badge-with-padding badge badge-warning">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    </span>
                                </div>
                            </td>
                        @endcanany--}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
                    <td colspan="12">
                        {{ $mantenimientos->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{ $mantenimientos->count() }}</strong> registros de
                            <strong>{{ $mantenimientos->total() }}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
