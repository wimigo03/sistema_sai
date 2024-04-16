<div class="form-group row">
    <div class="col-md-12">
        <table class="table table-borderless hoverTable table-striped" id="#">
            <thead>
                <tr class="font-verdana-sm">
                    <th class="text-left p-1">ID</th>
                    <th class="text-left p-1">NOMBRE</th>
                    <th class="text-left p-1">USUARIO</th>
                    <th class="text-left p-1">EMAIL</th>
                    {{-- <th class="text-left p-1">ROL</th> --}}
                    <th class="text-center p-1">ESTADO</th>
                    <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="font-verdana-sm">
                        <td class="text-left p-1" style="vertical-align: middle;">{{ $user->id }}</td>
                        <td class="text-left p-1" style="vertical-align: middle;">{{ $user->nombre_completo }}</td>
                        <td class="text-left p-1" style="vertical-align: middle;">{{ $user->name }}</td>
                        <td class="text-left p-1" style="vertical-align: middle;">{{ $user->email }}</td>
                        {{-- <td class="text-left p-1" style="vertical-align: middle;">{{ $user->role->title }}</td> --}}
                        {{-- <td class="text-left p-1" style="vertical-align: middle;">{{ strtoupper($user->nombre_completo) }}</td> --}}
                        {{-- <td class="text-left p-1" style="vertical-align: middle;">{{ strtoupper($user->name) }}</td> --}}
                        {{-- <td class="text-left p-1" style="vertical-align: middle;">{{ strtoupper($user->email) }}</td> --}}
                        {{-- <td class="text-left p-1" style="vertical-align: middle;">{{ strtoupper($user->role->title) }}</td> --}}
                        <td class="text-center p-1" style="vertical-align: middle;">
                            {{--<span class="badge {{ $user->icono_estado }} badge-with-padding">--}}
                                {{ $user->status }}
                            {{--</span>--}}
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
                                                <button type="submit" onclick="return confirm('Se dará de baja al Usuario. ¿Esta Ud. seguro...?')" class="btn btn-xs btn-success">
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
                                                    <i class="fa fa-lg fa-arrow-down" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                        </form>
                                    @endcan
                                @endif

                        </td>
                    </tr>
                @empty
                    <tr class="font-verdana-sm">
                        <td colspan="100%" class="text-center text-muted py-3">No existen Registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <div class="card-footer font-verdana-sm">
            {{ $users->links() }}
            <p class="text-muted">
                Mostrando
                <strong>{{ $users->count() }}</strong>
                registros de
                <strong>{{$users->total() }}</strong>
                totales
            </p>
        </div>
    </div>
</div>
