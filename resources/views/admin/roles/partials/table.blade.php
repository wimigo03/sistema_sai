<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana">
                    <td class="text-left p-1"><b>ID</b></td>
                    <td class="text-left p-1"><b>UNIDAD ADMINSTRATIVA</b></td>
                    <td class="text-left p-1"><b>TITULO</b></td>
                    <td class="text-left p-1"><b>CODIGO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $datos)
                    <tr class="font-verdana">
                        <td class="text-left p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->dea != null ? $datos->dea->descripcion :'[Error]' }}</td>
                        <td class="text-left p-1">{{ $datos->title }}</td>
                        <td class="text-left p-1">{{ $datos->short_code }}</td>
                        <td class="text-center p-1">{{ $datos->status }}</td>
                        <td class="text-center p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="cursor: pointer;">
                                <a href="{{ route('roles.show',$datos->id) }}" class="btn btn-xs btn-info">
                                    <i class="fa-solid fa-lg fa-list"></i>
                                </a>
                            </span>
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                <a href="{{ route('roles.edit',$datos->id) }}" class="btn btn-xs btn-warning">
                                    <i class="fa-solid fa-lg fa-pen-to-square"></i>
                                </a>
                            </span>
                            @if (App\Models\Role::ESTADOS[$datos->estado] == 'HABILITADO')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Dehabilitar" style="cursor: pointer;">
                                    <a href="{{ route('roles.deshabilitar',$datos->id) }}" class="btn btn-xs btn-danger">
                                        <i class="fa-regular fa-lg fa-circle-down"></i>
                                    </a>
                                </span>
                            @else
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                    <a href="{{ route('roles.habilitar',$datos->id) }}" class="btn btn-xs btn-success">
                                        <i class="fa-regular fa-lg fa-circle-up"></i>
                                    </a>
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana">
                    <td colspan="12">
                        {{ $roles->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{$roles->count()}}</strong> registros de
                            <strong>{{$roles->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>