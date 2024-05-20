<div class="form-group row abs-center">
    <div class="col-md-8 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-verdana-11">
                    <td class="text-center p-1"><b>ID</b></td>
                    <td class="text-center p-1"><b>DIRECCION ADM.</b></td>
                    <td class="text-center p-1"><b>TITULO</b></td>
                    <td class="text-center p-1"><b>NOMBRE</b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $datos)
                    <tr class="font-verdana-11">
                        <td class="text-center p-1">{{ $datos->id }}</td>
                        <td class="text-center p-1">{{ $datos->dea->descripcion }}</td>
                        <td class="text-left p-1">{{ $datos->title }}</td>
                        <td class="text-left p-1">{{ $datos->name }}</td>
                        <td class="text-center p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                <a href="{{ route('permissions.edit',$datos->id) }}" class="badge-with-padding badge badge-warning">
                                    <i class="fa-solid fa-pen-to-square fa-fw"></i>
                                </a>
                            </span>
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle de roles" style="cursor: pointer;">
                                <a href="{{ route('permissions.show',$datos->id) }}" class="badge-with-padding badge badge-primary">
                                    <i class="fa-solid fa-list fa-fw"></i>
                                </a>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana-11">
                    <td colspan="12">
                        {{ $permissions->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{$permissions->count()}}</strong> registros de
                            <strong>{{$permissions->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
