<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange sortable" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-center p-1">DISTRITO</th>
                    <th class="text-center p-1">BARRIO</th>
                    <th class="text-center p-1">LUGAR DE ENTREGA</th>
                    <th class="text-center p-1">DIA</th>
                    <th class="text-center p-1">FECHA</th>
                    <th class="text-center p-1">HORA DE INICIO</th>
                    <th class="text-center p-1">HORA FINAL</th>
                    <th class="text-center p-1">HAB.</th>
                    <th class="text-center p-1">NO REG.</th>
                    <th class="text-center p-1">REG.</th>
                    <th class="text-center p-1">ENT.</th>
                    <th class="text-center p-1">NO ENT.</th>
                    <th class="text-center p-1">R.</th>
                    <th class="text-center p-1">ESTADO</th>
                    @canany(['canasta.entregas.index','canasta.paquetes.barrio.editar'])
                        <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($paquetes_barrios as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-center p-1">{{ $datos->distrito->nombre }}</td>
                        <td class="text-justify p-1">{{ $datos->barrio->nombre }}</td>
                        <td class="text-justify p-1">{{ $datos->lugar_entrega }}</td>
                        <td class="text-center p-1">{{ $datos->fecha_entrega != null ? mb_strtoupper(strftime('%A', strtotime($datos->fecha_entrega)), 'UTF-8') : '' }}</td>
                        <td class="text-center p-1">{{ $datos->fecha_entrega != null ? \Carbon\Carbon::parse($datos->fecha_entrega)->format('d/m/Y') : '' }}</td>
                        <td class="text-center p-1">{{ $datos->hora_inicio }}</td>
                        <td class="text-center p-1">{{ $datos->hora_final }}</td>
                        <td class="text-center p-1">{{ $datos->total_habilitados }}</td>
                        <td class="text-center p-1">
                            @if ($datos->total_no_registrados < 0)
                                <span class="badge badge-danger font-roboto-11">
                                    {{ $datos->total_no_registrados }}
                                </span>
                            @else
                                @if ($datos->total_no_registrados == 0)
                                    {{ $datos->total_no_registrados }}
                                @else
                                    <span class="badge badge-warning font-roboto-11">
                                        {{ $datos->total_no_registrados }}
                                    </span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center p-1">{{ $datos->total_registrados }}</td>
                        <td class="text-center p-1">{{ $datos->total_entregados }}</td>
                        <td class="text-center p-1">{{ $datos->total_no_entregados }}</td>
                        <td class="text-center p-1">{{ $datos->total_resagados }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['canasta.entregas.index','canasta.paquetes.barrio.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('canasta.entregas.index')
                                        <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Ir a beneficiarios">
                                            <a  href="{{ route('entregasdisc.index',$datos->id) }}" class="badge-with-padding badge badge-primary font-roboto-11">
                                                <i class="fa-solid fa-users fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('canasta.paquetes.barrio.editar')
                                        @if ($datos->estado == '1')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                                                <a  href="{{ route('paquetes.barrio.editar',$datos->id) }}" class="badge-with-padding badge badge-warning font-roboto-11">
                                                    <i class="fa-solid fa-edit fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar No permitido">
                                                <a  href="#" class="badge-with-padding badge badge-secondary font-roboto-11">
                                                    <i class="fa-solid fa-edit fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana-11">
                    <td colspan="14">
                        {{ $paquetes_barrios->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{ $paquetes_barrios->count() }}</strong> registros de
                            <strong>{{ $paquetes_barrios->total() }}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
