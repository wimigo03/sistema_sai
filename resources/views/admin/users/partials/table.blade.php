<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1">
        <table class="table table-borderless hoverTable table-striped hover-orange" id="#">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-center p-1">DEA</th>
                    <th class="text-center p-1">NOMBRE</th>
                    <th class="text-center p-1">USUARIO</th>
                    <th class="text-center p-1">AREA</th>
                    <th class="text-center p-1">ESTADO</th>
                    <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $user->nombre_completo }}</td>
                        <td class="text-left p-1">{{ $user->name }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $user->icono_estado }}">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td class="text-center p-1">
                            @can('users.editar')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                                    <a href="{{ route('users.edit',$user->id) }}" class="btn btn-xs btn-warning">
                                        <i class="fa fa-lg fa-edit" aria-hidden="true"></i>
                                    </a>
                                </span>
                            @endcan
                                @if ($user->estadouser == 1)
                                    @can('users.deshabilitar')
                                        <form action="{{ route('users.baja',$user->id) }}" class="d-inline-block" method="get">
                                            @csrf
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar">
                                                <button type="submit" onclick="return confirm('Se dará de baja al Usuario. ¿Esta Ud. seguro...?')" class="btn btn-xs btn-danger">
                                                    <i class="fa fa-lg fa-arrow-down" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                        </form>
                                    @endcan
                                @else
                                    @can('users.habilitar')
                                        <form action="{{ route('users.alta', $user->id) }}" class="d-inline-block" method="get">
                                            @csrf
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar">
                                                <button type="submit" onclick="return confirm('Se dará de baja al Usuario. ¿Esta Ud. seguro...?')" class="btn btn-xs btn-success">
                                                    <i class="fa fa-lg fa-arrow-up" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                        </form>
                                    @endcan
                                @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
                    <td colspan="12">
                        {{ $users->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$users->count()}}</strong> registros de
                            <strong>{{$users->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
