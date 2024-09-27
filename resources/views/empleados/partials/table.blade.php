<div class="form-group row abs-center">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-roboto-10">
                    {{-- @if(Auth::user()->hasRole('administrator'))
                        <th class="text-left p-1">_ID_</th>
                    @endif
                    <th class="text-left p-1">AREA - UNIDAD</th> --}}
                    <th class="text-left p-1" style="width:10%; word-wrap: break-word;">AREA ASIGNADA</th>
                    <th class="text-left p-1" style="width:10%; word-wrap: break-word;">CARGO</th>
                    <th class="text-left p-1" style="width:25%; word-wrap: break-word;">NOMBRE COMPLETO</th>
                    <th class="text-center p-1" style="width:10%; word-wrap: break-word;">N°&nbsp;CARNET</th>
                    <th class="text-center p-1" style="width:5%; word-wrap: break-word;">M/F</th>
                    <th class="text-center p-1" style="width:5%; word-wrap: break-word;">P/C</th>
                    <th class="text-center p-1" style="width:8%; word-wrap: break-word;">INGRESO</th>
                    <th class="text-center p-1" style="width:10%; word-wrap: break-word;">RETIRO&nbsp;/&nbsp;C.C.</th>
                    <th class="text-center p-1" style="width:5%; word-wrap: break-word;">ESTADO</th>
                    @canany(['empleados.show','empleados.editar'])
                        <th class="text-center p-1" style="width:12%; word-wrap: break-word;"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($empleados as $datos)
                    <tr class="font-roboto-10">
                        {{-- @if(Auth::user()->hasRole('administrator'))
                            <td class="text-left p-1">
                                {{ $datos->idemp }}
                            </td>
                        @endif
                        <td class="text-left p-1">
                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->area->nombrearea }}" style="cursor: pointer;">
                                {{ $datos->area_unidad }}
                            </span>
                        </td> --}}
                        <td class="text-left p-1">
                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->area_asignada }}" style="cursor: pointer;">
                                {{ $datos->area_asignada_corta }}
                            </span>
                        </td>
                        <td class="text-left p-1">
                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->file_cargo }}" style="cursor: pointer;">
                                {{ $datos->file_cargo_corto }}
                            </span>
                        </td>
                        <td class="text-left p-1">{{ $datos->nombres . ' ' . $datos->ap_pat . ' ' . $datos->ap_mat }}</td>
                        <td class="text-center p-1">{{ $datos->ci .' ' . $datos->extension }}</td>
                        <td class="text-center p-1">{{ $datos->sexos }}</td>
                        <td class="text-center p-1">{{ $datos->ultimo_tipo_contrato }}</td>
                        <td class="text-center p-1">{{ $datos->ultimo_contrato_ingreso != null ? \Carbon\Carbon::parse($datos->ultimo_contrato_ingreso)->format('d/m/Y') : '' }}</td>
                        @php
                            $parpadear = '';
                            if($datos->estado == '1'){
                                if($datos->fecha_conclusion_contrato != null){
                                    $fecha_inicial = strtotime($datos->fecha_conclusion_contrato);
                                    $fecha_final = strtotime(date('Y-m-d'));
                                    $diferenciaSegundos = $fecha_inicial - $fecha_final;
                                    $diferenciaDias = $diferenciaSegundos / (60 * 60 * 24);
                                    if($diferenciaDias < 10){
                                        $parpadear = 'parpadear';
                                    }
                                }
                            }
                        @endphp
                        <td class="text-center p-1 {{ $parpadear }}">
                            @if ($datos->ultimo_contrato_retiro != null)
                                R.-&nbsp;{{ \Carbon\Carbon::parse($datos->ultimo_contrato_retiro)->format('d/m/Y') }}
                                <br>
                            @endif
                            @if ($datos->fecha_conclusion_contrato != null)
                                C.-&nbsp;{{ \Carbon\Carbon::parse($datos->fecha_conclusion_contrato)->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="text-center p-1">
                            {{-- <i class='{{ $datos->status_check }}'></i> --}}
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['empleados.show','empleados.editar','users.create'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    <select id="{{ $datos->idemp }}" onchange="redireccionar(this.id);" class="form-control form-control-sm font-roboto-12 select2 options">
                                        <option value="">-</option>
                                        @can('empleados.show')
                                            <option value="show">Ir a detalle</option>
                                        @endcan
                                        @if ($datos->estado == '1')
                                            @can('empleados.editar')
                                                <option value="editar">Modificar</option>
                                            @endcan
                                        @endif
                                        @if ($datos->estado == '1')
                                            @can('empleados.retirar')
                                                <option value="retirar">Retirar</option>
                                            @endcan
                                        @else
                                            @can('empleados.recontratar')
                                                <option value="recontratar">Recontratar</option>
                                            @endcan
                                        @endif
                                        @can('empleados.show')
                                            <option value="kardex">Kardex</option>
                                        @endcan
                                        @if(Auth::user()->hasRole('administrator'))
                                            @if ($datos->user_registrado == null)
                                                <option value="usuario">Crear Usuario</option>
                                            @endif
                                        @endif
                                    </select>



                                    {{-- @can('empleados.show')
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
                                    &nbsp; --}}
                                    {{-- @can('users.create')
                                        @if ($datos->user_registrado != null)
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Actualizar Usuario" style="cursor: pointer;">
                                                <a href="{{ route('users.edit',$datos->user_registrado->id) }}" class="badge-with-padding badge badge-primary">
                                                    <i class="fas fa-user fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Crear Usuario" style="cursor: pointer;">
                                                <a href="{{ route('users._create',$datos->idemp) }}" class="badge-with-padding badge badge-secondary">
                                                    <i class="fas fa-user-times fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan --}}
                                    {{--@can('empleados.recontratar')
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
                    <td colspan="13">
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
