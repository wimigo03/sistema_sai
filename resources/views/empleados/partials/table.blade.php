<div class="form-group row abs-center">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-left p-1">AREA</th>
                    <th class="text-left p-1">CARGO</th>
                    <th class="text-left p-1">NOMBRE(S)</th>
                    <th class="text-left p-1">AP. PAT.</th>
                    <th class="text-left p-1">AP. MAT.</th>
                    <th class="text-left p-1">N° CARNET</th>
                    <th class="text-center p-1">TIPO</th>
                    <th class="text-center p-1">INGRESO</th>
                    <th class="text-center p-1">RETIRO</th>
                    <th class="text-center p-1">HAB.</th>
                    @canany(['empleados.show','empleados.editar'])
                        <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($empleados as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->area->nombrearea }}</td>
                        <td class="text-left p-1">{{ $datos->cargo_file . ' - ' . $datos->file_cargo }}</td>
                        <td class="text-left p-1">{{ $datos->nombres }}</td>
                        <td class="text-left p-1">{{ $datos->ap_pat }}</td>
                        <td class="text-left p-1">{{ $datos->ap_mat }}</td>
                        <td class="text-left p-1">{{ $datos->ci .' ' . $datos->extension }}</td>
                        <td class="text-center p-1">{{ $datos->ultimo_tipo_contrato }}</td>
                        <td class="text-center p-1">{{ $datos->ultimo_contrato_ingreso != null ? \Carbon\Carbon::parse($datos->ultimo_contrato_ingreso)->format('d/m/Y') : '' }}</td>
                        <td class="text-center p-1">{{ $datos->ultimo_contrato_retiro != null ? \Carbon\Carbon::parse($datos->ultimo_contrato_retiro)->format('d/m/Y') : '' }}</td>
                        <td class="text-center p-1"><i class='{{ $datos->status_check }}'></i></td>
                        @canany(['empleados.show','empleados.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('empleados.show')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Informacion de personal" style="cursor: pointer;">
                                            <a href="{{ route('empleado.show',$datos->idemp) }}" class="badge-with-padding badge badge-info">
                                                <i class="fas fa-list fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    &nbsp;
                                    @can('empleados.editar')
                                        @if ($datos->estado == '1')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                                <a href="{{ route('empleado.editar',$datos->idemp) }}" class="badge-with-padding badge badge-warning">
                                                    <i class="fas fa-edit fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar no permitido" style="cursor: pointer;">
                                                <span class="badge-with-padding badge badge-secondary">
                                                    <i class="fas fa-edit fa-fw"></i>
                                                </span>
                                            </span>
                                        @endif
                                    @endcan
                                    {{--&nbsp;
                                    @can('empleados.recontratar')
                                        @if ($datos->estado == '2')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Recontratar" style="cursor: pointer;">
                                                <a href="{{ route('empleado.recontratar',$datos->idemp) }}" class="badge-with-padding badge badge-primary">
                                                    <i class="fas fa-address-card fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Recontratar no permitido" style="cursor: pointer;">
                                                <span class="badge-with-padding badge badge-secondary">
                                                    <i class="fas fa-address-card fa-fw"></i>
                                                </span>
                                            </span>
                                        @endif
                                    @endcan
                                    &nbsp;
                                    @can('empleados.retirar')
                                        @if ($datos->estado == '1')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Retirar" style="cursor: pointer;">
                                                <a href="{{ route('empleado.retirar',$datos->idemp) }}" class="badge-with-padding badge badge-danger">
                                                    <i class="fas fa-user-times fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Retirar no permitido" style="cursor: pointer;">
                                                <span class="badge-with-padding badge badge-secondary">
                                                    <i class="fas fa-user-times fa-fw"></i>
                                                </span>
                                            </span>
                                        @endif
                                    @endcan--}}
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
                    <td colspan="12">
                        {{ $empleados->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$empleados->count()}}</strong> registros de
                            <strong>{{$empleados->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
