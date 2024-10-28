<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange sortable" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-justify p-1">N°</th>
                    <th class="text-justify p-1">NOMBRES</th>
                    <th class="text-justify p-1">APELLIDO PATERNO</th>
                    <th class="text-justify p-1">APELLIDO MATERNO</th>
                    <th class="text-justify p-1">N° CARNET</th>
                    <th class="text-center p-1">FECHA NAC.</th>
                    <th class="text-center p-1">EDAD</th>
                    <th class="text-center p-1">SEXO</th>
                    <th class="text-center p-1">FOTO</th>
                    <th class="text-center p-1">ESTADO</th>
                    @if ($paquete_barrio->estado == '1')
                        @canany(['canasta.entregas.habilitar','canasta.entregas.get.boleta'])
                            <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                        @endcanany
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($entregas as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-justify p-1" style="vertical-align: middle;">{{ $cont++ }}</td>
                        <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->nombres }}</td>
                        <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->ap }}</td>
                        <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->am }}</td>
                        <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->ci . ' ' . $datos->expedido }}</td>
                        <td class="text-center p-1" style="vertical-align: middle;">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->format('d/m/Y') : '' }}</td>
                        <td class="text-center p-1" style="vertical-align: middle;">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->age : '' }}</td>
                        <td class="text-center p-1" style="vertical-align: middle;">{{ $datos->sexo }}</td>
                        <td class="text-center p-1" style="vertical-align: middle;">
                            <img src="{{ asset(substr($datos->dir_foto, 3)) }}" class="imagen-beneficiario-table"/>
                        </td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @if ($paquete_barrio->estado == '1')
                            @canany(['canastadisc.entregas.habilitar','canastadisc.entregas.get.boleta'])
                                <td class="text-center p-1">
                                    <div class="d-flex justify-content-center">
                                        @can('canastadisc.entregas.habilitar')
                                            @if ($datos->estado == '1')
                                                {{--<span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Realizar entrega" style="cursor: pointer;">
                                                    <a href="{{ route('entregas.habilitar',$datos->entrega_id) }}" class="badge-with-padding badge badge-success font-roboto-10">
                                                        <i class="fas fa-arrow-right fa-fw"></i>
                                                    </a>
                                                </span>--}}
                                                @if ($datos->resagado == null)
                                                    <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Realizar entrega" style="cursor: pointer;">
                                                        <a href="#" class="badge-with-padding badge badge-success font-roboto-10" data-toggle="modal" data-target="#entregaModal" data-entrega-id="{{ $datos->entrega_id }}" data-beneficiario="{{ $datos->nombres . ' ' . $datos->ap . ' ' . $datos->am }}">
                                                            <i class="fas fa-arrow-right fa-fw"></i>
                                                        </a>
                                                    </span>
                                                @else
                                                    <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="No permitido" style="cursor: pointer;">
                                                        <a href="#" class="badge-with-padding badge badge-secondary font-roboto-10">
                                                            <i class="fas fa-arrow-right fa-fw"></i>
                                                        </a>
                                                    </span>
                                                @endif
                                            @else
                                                @if ($datos->resagado == null)
                                                    <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Restablecer" style="cursor: pointer;">
                                                        <a href="{{ route('entregasdisc.deshabilitar',$datos->entrega_id) }}" class="badge-with-padding badge badge-danger font-roboto-10">
                                                            <i class="fas fa-arrow-left fa-fw"></i>
                                                        </a>
                                                    </span>
                                                @else
                                                    <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="No permitido" style="cursor: pointer;">
                                                        <a href="#" class="badge-with-padding badge badge-secondary font-roboto-10">
                                                            <i class="fas fa-user fa-fw"></i>
                                                        </a>
                                                    </span>
                                                @endif
                                            @endif
                                        @endcan
                                        @can('canastadisc.entregas.get.boleta')
                                            <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Generar boleta de entrega" style="cursor: pointer;">
                                                <a href="{{ route('entregasdisc.get.boleta.entrega',$datos->entrega_id) }}" class="badge-with-padding badge badge-danger font-roboto-10" target="_blank">
                                                    <i class="fas fa-file-pdf fa-fw"></i>
                                                </a>
                                            </span>
                                        @endcan
                                        @can('canastadisc.entregas.editar')
                                            <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Cambiar de barrio" style="cursor: pointer;">
                                                <a href="{{ route('entregasdisc.editar',$datos->entrega_id) }}" class="badge-with-padding badge badge-warning font-roboto-10">
                                                    <i class="fas fa-edit fa-fw"></i>
                                                </a>
                                            </span>
                                        @endcan
                                    </div>
                                </td>
                            @endcanany
                        @endif
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana-11">
                    <td colspan="12">
                        {{ $entregas->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{ $entregas->count() }}</strong> registros de
                            <strong>{{ $entregas->total() }}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
