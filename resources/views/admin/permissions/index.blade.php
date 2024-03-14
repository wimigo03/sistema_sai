@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-header">MODULO PERMISOS</div>

        <div class="card-body table-responsive">
    
            <a href="{{ route('permissions.create') }}" class="btn btn-outline-primary">Agregar nuevo permiso</a>


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
  
                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-outline-warning">Editar</a>
 
                                <form action="{{ route('permissions.destroy', $permission->id) }}" class="d-inline-block" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Esta Ud. seguro?')" class="btn btn-sm btn-outline-danger">Borrar</button>
                                </form>
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
