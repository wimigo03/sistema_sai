@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-header">{{ __('Vista de roles') }}</div>

        <div class="card-body">

            <a href="{{ route('admin.roles.index') }}" class="btn btn-light">Volver</a>

            <br /><br />



                <table class="table table-borderless">

                    <tr>
                        <th width="25%">ID</th>
                        <td>{{ $role->id }}</td>
                    </tr>
                    <tr>
                        <th width="25%">Titulo</th>
                        <td>{{ $role->title }}</td>
                    </tr>
                    <tr>
                        <th width="25%">Codigo</th>
                        <td>{{ $role->short_code ?? "--" }}</td>
                    </tr>
                    <tr>
                        <th width="25%">Permisos</th>
                        <td>
                            @forelse ($role->permissions as $permission)
                                <div class="badge badge-info">{{ $permission->name }}</div>
                                @empty
                                No Permissions
                            @endforelse
                       </td>
                    </tr>

                </table>




        </div>
    </div>

@endsection
