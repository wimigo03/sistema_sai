@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-header">MODULO PERMISOS</div>

        <div class="card-body table-responsive">
            @can('permission_create')
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-outline-primary">Agregar nuevo permiso</a>
            @endcan

            <br /><br />



                <table class="table table-borderless hoverTable">
                            <tr class="bg-info text-light">
                                <th class="text-center">ID</th>
                                <th>Nombre</th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                    @forelse ($permissions as $permission)
                        <tr>
                            <td class="text-center">{{$permission->id}}</td>
                            <td>{{$permission->name}}</td>
                            <td>
                                    @can('permission_edit')
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                                    @endcan
                                    @can('permission_delete')
                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" class="d-inline-block" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Esta Ud. seguro?')" class="btn btn-sm btn-outline-danger">Borrar</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center text-muted py-3">No Permissions Found</td>
                            </tr>
                    @endforelse
                </table>




            @if($permissions->total() > $permissions->perPage())
            <br><br>
            {{$permissions->links()}}
            @endif

        </div>
    </div>

@endsection
