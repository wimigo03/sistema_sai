@if (!isset($beneficiarios))
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1 table-responsive">
            <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="dataTable">
                <thead>
                    <tr class="font-roboto-11">
                        <td class="text-center p-1"><b>CODIGO</b></td>
                        <td class="text-center p-1"><b>NOMBRE (S)</b></td>
                        <td class="text-center p-1"><b>AP. PAT.</b></td>
                        <td class="text-center p-1"><b>AP. MAT.</b></td>
                        <td class="text-center p-1"><b>CI</b></td>
                        <td class="text-center p-1"><b>SEXO</b></td>
                        <td class="text-center p-1"><b>BARRIO</b></td>
                        {{--<td class="text-center p-1"><b>DIRECCION</b></td>--}}
                        <td class="text-center p-1"><b>FOTO</b></td>
                        <td class="text-center p-1"><b>ESTADO</b></td>
                        <td class="text-center p-1">
                            @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.datos'])
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            @endcanany
                        </td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 table-responsive">
            <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
                <thead>
                    <tr class="font-roboto-11">
                        <td class="text-center p-1"><b>CODIGO</b></td>
                        <td class="text-center p-1"><b>NOMBRE (S)</b></td>
                        <td class="text-center p-1"><b>AP. PAT.</b></td>
                        <td class="text-center p-1"><b>AP. MAT.</b></td>
                        <td class="text-center p-1"><b>CI</b></td>
                        <td class="text-center p-1"><b>SEXO</b></td>
                        <td class="text-center p-1"><b>BARRIO</b></td>
                        {{--<td class="text-center p-1"><b>DIRECCION</b></td>--}}
                        <td class="text-center p-1"><b>FOTO</b></td>
                        <td class="text-center p-1"><b>ESTADO</b></td>
                        @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.datos'])
                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beneficiarios as $datos)
                        <tr class="font-roboto-11">
                            <td class="text-center p-1">{{ $datos->id }}</td>
                            <td class="text-center p-1">{{ $datos->nombres }}</td>
                            <td class="text-center p-1">{{ $datos->ap }}</td>
                            <td class="text-center p-1">{{ $datos->am }}</td>
                            <td class="text-center p-1">{{ $datos->ci . '-' . $datos->expedido }}</td>
                            <td class="text-center p-1">{{ $datos->sexo }}</td>
                            <td class="text-center p-1">{{ $datos->barrio->nombre }}</td>
                            {{--<td class="text-left p-1">{{ $datos->direccion }}</td>--}}
                            <td class="text-center p-1"><img src="{{ asset(substr($datos->dirFoto , 3)) }}" align="center" height="30" with="30" /></td>
                            <td class="text-center p-1">
                                <span class="{{ $datos->colorStatus }}">
                                    {{ $datos->status }}
                                </span>
                            </td>
                            @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.datos'])
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
                                        @can('canasta.beneficiarios.datos')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a kardex">
                                                <a href="{{ route('beneficiarios.beneficiario_datos', $datos->id) }}" class="badge-with-padding badge badge-primary" target="_blank">
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
