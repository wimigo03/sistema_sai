<div class="form-group row abs-center">
    <div class="col-md-10 pr-1 pl-1">
        <table class="table table-bordered hoverTable table-striped hover-orange" id="#" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>GESTION</b></td>
                    <td class="text-center p-1"><b>PERIODO</b></td>
                    <td class="text-center p-1"><b>ENTREGA</b></td>
                    <td class="text-center p-1"><b>DISPONIBLES</b></td>
                    <td class="text-center p-1"><b>REGISTRADOS</b></td>
                    <td class="text-center p-1"><b>ENTREGADOS</b></td>
                    <td class="text-center p-1"><b>NO ENTREGADOS</b></td>
                    <td class="text-center p-1"><b>RESAGADOS</b></td>
                    @canany(['canastadisc.paquetes.editar','canastadisc.paquetes.barrio.index'])
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($paquetes as $datos)
                <tr class="font-roboto-11">
                    <td class="text-center p-1">{{ $datos->gestion }}</td>
                    <td class="text-center p-1">
                        @php
                            $periodos = DB::table('paquete_periodo as a')
                                            ->join('periodos as b','b.id','a.id_periodo')
                                            ->where('a.id_paquete',$datos->id)
                                            ->where('a.estado','1')
                                            ->get();
                        @endphp
                        @foreach ($periodos as $periodo)
                            {{ $periodo->mes }}
                        @endforeach
                    </td>
                    <td class="text-center p-1">{{ $datos->numero }}</td>
                    <td class="text-center p-1">#{{-- $datos->registrados --}}</td>
                    <td class="text-center p-1">{{ $datos->registrados }}</td>
                    <td class="text-center p-1">{{ $datos->entregados }}</td>
                    <td class="text-center p-1">{{ $datos->no_entregados }}</td>
                    <td class="text-center p-1">{{ $datos->resagados }}</td>
                    @canany(['canastadisc.paquetes.editar','canastadisc.paquetes.barrio.index'])
                        <td class="text-center p-1">
                            <div class="d-flex justify-content-center">
                                @can('canastadisc.paquetes.editar')
                                    <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Modificar">
                                        <a href="{{-- route('paquetes.editar', $datos->id) --}}" class="badge-with-padding badge badge-secondary font-roboto-11">
                                            <i class="fa-regular fa-pen-to-square fa-fw"></i>
                                        </a>
                                    </span>
                                @endcan
                                @can('canastadisc.paquetes.barrio.index')
                                    <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Ir a cronograma de entrega">
                                        <a  href="{{ route('paquetes.barriodisc.index',$datos->id) }}" class="badge-with-padding badge badge-warning font-roboto-11">
                                            <i class="fas fa-box fa-fw"></i>
                                        </a>
                                    </span>
                                @endcan
                                @can('canastadisc.paquetes.beneficiarios')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a beneficiarios">
                                        <a  href="{{ route('paquetesdisc.beneficiarios',$datos->id) }}" class="badge-with-padding badge badge-primary font-roboto-11">
                                            <i class="fas fa-users fa-fw"></i>
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
                        {{ $paquetes->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{ $paquetes->count() }}</strong> registros de
                            <strong>{{ $paquetes->total() }}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>


</div>
