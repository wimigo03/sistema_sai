<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-verdana-11">
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-center p-1"><b>USUARIO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['canasta.distritos.editar','canasta.distritos.habilitar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($distritos as $datos)
                    <tr class="font-verdana-11">
                        <td class="text-center p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-center p-1">{{ strtoupper($datos->user->name) }}</td>
                        <td class="text-center p-1">{{ $datos->status }}</td>
                        <td class="text-center p-1">
                            <div class="d-flex justify-content-center">
                                @can('canasta.distritos.editar')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                        <a href="{{ route('distritos.editar',$datos->id) }}" class="btn btn-xs btn-warning">
                                            <i class="fa-solid fa-lg fa-pen-to-square"></i>
                                        </a>
                                    </span>
                                    &nbsp;
                                @endcan
                                @can('canasta.distritos.habilitar')
                                    @if (App\Models\Canasta\Distrito::ESTADOS[$datos->estado] == 'HABILITADO')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Dehabilitar" style="cursor: pointer;">
                                            <a href="{{ route('distritos.deshabilitar',$datos->id) }}" class="btn btn-xs btn-danger">
                                                <i class="fa-regular fa-lg fa-circle-down"></i>
                                            </a>
                                        </span>
                                        &nbsp;
                                    @else
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                            <a href="{{ route('distritos.habilitar',$datos->id) }}" class="btn btn-xs btn-success">
                                                <i class="fa-regular fa-lg fa-circle-up"></i>
                                            </a>
                                        </span>
                                        &nbsp;
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana-11">
                    <td colspan="12">
                        {{ $distritos->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{$distritos->count()}}</strong> registros de
                            <strong>{{$distritos->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
