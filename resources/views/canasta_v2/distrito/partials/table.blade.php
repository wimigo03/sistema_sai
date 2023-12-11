<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana">
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-center p-1"><b>USUARIO</b></td>
                    <td class="text-center p-1"><b>DEA</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($distritos as $datos)
                    <tr class="font-verdana">
                        <td class="text-center p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-center p-1">{{ strtoupper($datos->user->name) }}</td>
                        <td class="text-center p-1">{{ $datos->dea->nombre }}</td>
                        <td class="text-center p-1">{{ $datos->status }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana">
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