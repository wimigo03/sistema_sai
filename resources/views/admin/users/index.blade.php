@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-header">{{ __('Lista de usuarios') }}</div>

        <div class="card-body table-responsive">
            @can('user_create')
                <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary">Agregar Nuevo Usuario</a>
            @endcan

            <br /><br />



            <table class="table table-borderless hoverTable">
                <tr class="bg-info text-light">
                    <th class="text-center">ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->idu }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->title }}</td>
                        <td>

                            @can('user_edit')
                                <a href="users/{{ $user->idu }}/edit" class="btn btn-sm btn-primary">Editar</a>
                            @endcan
                            @can('user_delete')
                                @if ($user->estadouser == 1)
                                    <form action="{{ route('users.baja',$user->idu) }}" class="d-inline-block"
                                        method="get">
                                        @csrf

                                        <button type="submit" onclick="return confirm('Se dará de baja al Usuario. ¿Esta Ud. seguro...?')"
                                            class="btn btn-sm btn-success">Desactivar</button>
                                    </form>
                                @else
                                    <form action="{{ route('users.alta', $user->idu) }}" class="d-inline-block"
                                        method="get">
                                        @csrf

                                        <button type="submit" onclick="return confirm('Se dará de alta al Usuario. ¿Esta Ud. seguro...?')"
                                            class="btn btn-sm btn-danger">Activar</button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted py-3">No Users Found</td>
                    </tr>
                @endforelse
            </table>




            @if ($users->total() > $users->perPage())
                <br><br>
                {{ $users->links() }}
            @endif

        </div>
    </div>

@endsection
