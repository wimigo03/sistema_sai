@if (!isset($beneficiarios))
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1 table-responsive">
            <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="dataTable">
                <thead>
                    <tr class="font-roboto-11">
                        {{--<th>CODIGO</th>--}}
                        <th>DISTRITO</th>
                        <th width="20%">BARRIO</th>
                        <th>NOMBRE (S)</th>
                        <th>AP. PATERNO</th>
                        <th>AP. MATERNO</th>
                        <th>NRO. CARNET</th>
                        <th>SEXO</th>
                        <th>EDAD</th>
                        <th>OCUPACION</th>
                        <th>ESTADO</th>
                        <th><i class="fa-solid fa-camera-retro fa-fw"></i></th>
                        @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])
                            <th>
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        {{--<th></th>--}}
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])
                            <th></th>
                        @endcanany
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@else
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1 table-responsive">
            <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
                <thead>
                    <tr class="font-roboto-11">
                        {{--<td class="text-center p-1"><b>CODIGO</b></td>--}}
                        <td class="text-center p-1"><b>DISTRITO</b></td>
                        <td class="text-justify p-1" width="20%"><b>BARRIO</b></td>
                        <td class="text-justify p-1"><b>NOMBRE (S)</b></td>
                        <td class="text-justify p-1"><b>AP. PATERNO</b></td>
                        <td class="text-justify p-1"><b>AP. MATERNO</b></td>
                        <td class="text-center p-1"><b>NRO. CARNET</b></td>
                        <td class="text-center p-1"><b>SEXO</b></td>
                        <td class="text-center p-1"><b>EDAD</b></td>
                        <td class="text-center p-1"><b>OCUPACION</b></td>
                        <td class="text-center p-1"><b>ESTADO</b></td>
                        <td class="text-center p-1">
                            <i class="fa-solid fa-camera-retro fa-fw"></i>
                        </td>
                        @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])
                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beneficiarios as $datos)
                        <tr class="font-roboto-10">
                            {{--<td class="text-center p-1">{{ $datos->id }}</td>--}}
                            <td class="text-center p-1">{{ $datos->distrito->nombre }}</td>
                            <td class="text-justify p-1">{{ $datos->barrio->nombre }}</td>
                            <td class="text-justify p-1">{{ $datos->nombres }}</td>
                            <td class="text-justify p-1">{{ $datos->ap }}</td>
                            <td class="text-justify p-1">{{ $datos->am }}</td>
                            <td class="text-center p-1">{{ $datos->ci . '-' . $datos->expedido }}</td>
                            <td class="text-center p-1">{{ $datos->sexo }}</td>
                            <td class="text-center p-1">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->age : '' }}</td>
                            <td class="text-center p-1">{{ $datos->ocupacion->ocupacion }}</td>
                            <td class="text-center p-1">
                                <span class="{{ $datos->colorStatus }}">
                                    {{ $datos->status }}
                                </span>
                            </td>
                            <td class="text-center p-1">
                                <img src="{{ asset('imagenes/fotos-30px/' . $datos->photo) }}" align="center" height="30" with="30" />
                            </td>
                            @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])
                                <td class="text-center p-1">
                                    <div class="d-flex justify-content-center">
                                        @can('canasta.beneficiarios.editar')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                                                <a href="{{ route('beneficiarios.editar', $datos->id) }}" class="badge-with-padding badge badge-warning">
                                                    <i class="fa-solid fa-pen-to-square fa-fw"></i>
                                                </a>
                                            </span>
                                            &nbsp;
                                        @endcan
                                        @can('canasta.beneficiarios.show')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a kardex">
                                                <a href="{{ route('beneficiarios.show', $datos->id) }}" class="badge-with-padding badge badge-primary" target="_blank">
                                                    <i class="fa fa-id-card fa-fw" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                            &nbsp;
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
                            {{ $beneficiarios->appends(Request::all())->links() }}
                            <p class="text-muted">Mostrando
                                <strong>{{ $beneficiarios->count() }}</strong> registros de
                                <strong>{{ $beneficiarios->total() }}</strong> totales
                            </p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endif
