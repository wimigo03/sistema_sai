<div class="form-group row abs-center">
    <div class="col-md-10 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>ID</b></td>
                    <td class="text-center p-1"><b>UNIDAD ADM.</b></td>
                    <td class="text-center p-1"><b>TITULO</b></td>
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-center p-1">{{ $datos->id }}</td>
                        <td class="text-center p-1">{{ $datos->dea != null ? $datos->dea->descripcion :'[Error]' }}</td>
                        <td class="text-center p-1">{{ $datos->title }}</td>
                        <td class="text-center p-1">{{ $datos->short_code }}</td>
                        <td class="text-center p-1">{{ $datos->status }}</td>
                        <td class="text-center p-1">
                            <a href="{{ route('roles.show',$datos->id) }}" class="badge-with-padding badge badge-info font-roboto-10">
                                <i class="fa-solid fa-list fa-fw"></i> Ir a detalle
                            </a>
                            <a href="{{ route('roles.edit',$datos->id) }}" class="badge-with-padding badge badge-warning font-roboto-10">
                                <i class="fa-solid fa-pen-to-square fa-fw"></i> Modificar
                            </a>
                            @if (App\Models\Role::ESTADOS[$datos->estado] == 'HABILITADO')
                                <a href="{{ route('roles.deshabilitar',$datos->id) }}" class="badge-with-padding badge badge-danger font-roboto-10">
                                    <i class="fa-regular fa-circle-down fa-fw"></i> Inhabilitar
                                </a>
                            @else
                                <a href="{{ route('roles.habilitar',$datos->id) }}" class="badge-with-padding badge badge-success font-roboto-10">
                                    <i class="fa-regula fa-circle-up fa-fw"></i> Habilitar
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
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
