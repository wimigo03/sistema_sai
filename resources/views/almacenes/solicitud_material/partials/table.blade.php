<div class="row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>N° SOL.</b></td>
                    <td class="text-center p-1"><b>FECHA SOL.</b></td>
                    <td class="text-center p-1"><b>UNIDAD SOLICITANTE</b></td>
                    <td class="text-center p-1"><b>SOLICITANTE</b></td>
                    <td class="text-center p-1"><b>PROGRAMA</b></td>
                    <td class="text-center p-1"><b>OBSERVACIONES</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['solicitud.material.show'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($solicitudes_materiales as $datos)
                    <tr class="font-roboto-10">
                        <td class="text-center p-1">{{ $datos->cod_solicitud }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fsolicitud)->format('d/m/Y') }}</td>
                        <td class="text-center p-1">{{ $datos->area->alias }}</td>
                        <td class="text-center p-1">{{ strtoupper($datos->solicitante->name) }}</td>
                        <td class="text-center p-1">{{ $datos->cprogramatica->codigo }}</td>
                        <td class="text-justify p-1">{{ strtoupper($datos->obs) }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['solicitud.material.show'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('solicitud.material.show')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="cursor: pointer;">
                                            <a href="{{ route('solicitud.material.show',$datos->id) }}" class="badge-with-padding badge badge-primary">
                                                <i class="fas fa-paper-plane fa-fw"></i>
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
                        {{ $solicitudes_materiales->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$solicitudes_materiales->count()}}</strong> registros de
                            <strong>{{$solicitudes_materiales->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
