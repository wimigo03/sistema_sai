<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana">
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    {{--<td class="text-left p-1"><b>TIPO</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-left p-1"><b>DISTRITO</b></td>
                    <td class="text-left p-1"><b>DEA</b></td>
                    <td class="text-left p-1"><b>USUARIO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>--}}
                </tr>
            </thead>
            <tbody>
                @foreach ($comprass as $datos)
                    <tr class="font-verdana">
                        <td class="text-center p-1">{{ $datos->idcompra }}</td>
                        {{--<td class="text-left p-1">{{ $datos->tipo_b }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->distrito->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->dea->nombre }}</td>
                        <td class="text-left p-1">{{ strtoupper($datos->user->name) }}</td>
                        <td class="text-center p-1">{{ $datos->status }}</td>
                        <td class="text-center p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                <a href="{{ route('barrios.editar',$datos->id) }}" class="btn btn-xs btn-warning">
                                    <i class="fa-solid fa-lg fa-pen-to-square"></i>
                                </a>
                            </span>
                            @if (App\Models\Canasta\Barrio::ESTADOS[$datos->estado] == 'HABILITADO')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Dehabilitar" style="cursor: pointer;">
                                    <a href="{{ route('barrios.deshabilitar',$datos->id) }}" class="btn btn-xs btn-danger">
                                        <i class="fa-regular fa-lg fa-circle-down"></i>
                                    </a>
                                </span>
                            @else
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                    <a href="{{ route('barrios.habilitar',$datos->id) }}" class="btn btn-xs btn-success">
                                        <i class="fa-regular fa-lg fa-circle-up"></i>
                                    </a>
                                </span>
                            @endif
                        </td>--}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana">
                    <td colspan="12">
                        {{ $comprass->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{$comprass->count()}}</strong> registros de
                            <strong>{{$comprass->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>