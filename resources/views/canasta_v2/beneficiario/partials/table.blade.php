<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana-11">
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    <td class="text-left p-1"><b>NOMBRES</b></td>
                    <td class="text-left p-1"><b>AP_PAT</b></td>
                    <td class="text-left p-1"><b>AP_MAT</b></td>
                    <td class="text-left p-1"><b>CI</b></td>
                    <td class="text-left p-1"><b>BARRIO</b></td>
                    <td class="text-left p-1"><b>DIRECCION</b></td>
                    <td class="text-left p-1"><b>FOTO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>


                    @can('canasta.beneficiarios.editar')
                        <td class="text-center p-1 font-weight-bold">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </td>
                    @endcan
                    @can('canasta.beneficiarios.datos')
                    <td class="text-center p-1 font-weight-bold">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </td>
                @endcan

                </tr>
            </thead>
            <tbody>
                @foreach ($beneficiarios as $datos)
                    <tr class="font-verdana-11">
                        <td class="text-center p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->nombres }}</td>
                        <td class="text-left p-1">{{ $datos->ap }}</td>
                        <td class="text-left p-1">{{ $datos->am }}</td>
                        <td class="text-left p-1">{{ $datos->ci }}</td>
                        <td class="text-left p-1">{{ $datos->barrio->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->direccion }}</td>
                        <td class="text-center p-1"><img src="{{ asset(substr($datos->dirFoto , 3)) }}" align="center" height="30" with="30" /></td>


                        @if (strtoupper($datos->status) == 'ACTIVO')
                        <td class="text-left p-1" style="color: green;font-weight: bold;">{{ strtoupper($datos->status) }}</td>
                        @elseif(strtoupper($datos->status) == 'FALLECIDO')
                        <td class="text-left p-1" style="color: red;font-weight: bold;">{{ strtoupper($datos->status) }}</td>
                        @elseif(strtoupper($datos->status) == 'BAJA')
                        <td class="text-left p-1" style="color: orange;font-weight: bold;">{{ strtoupper($datos->status) }}</td>
                        @elseif(strtoupper($datos->status) == 'PENDIENTE')
                        <td class="text-left p-1" style="color: blue;font-weight: bold;">{{ strtoupper($datos->status) }}</td>
                        @endif

                        @can('canasta.beneficiarios.editar')
                            <td style="padding: 0;" class="text-center p-1">

                                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Beneficiario">
                                    <a href="{{ route('beneficiarios.editar', $datos->id) }}">
                                        <span class="text-warning">
                                            <i class="fas fa-lg fa-edit" style="color:blue"></i>
                                        </span>
                                    </a>
                                </span>

                            </td>
                        @endcan

                        @can('canasta.beneficiarios.datos')
                            <td style="padding: 0;" class="text-center p-1">

                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ver kardex">
                                    <a href="{{ route('beneficiarios.beneficiario_datos', $datos->id) }}" target="_blank">
                                        <span class="text-warning">
                                            <i class="fa fa-lg  fa-id-card" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </span>

                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana-11">
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
