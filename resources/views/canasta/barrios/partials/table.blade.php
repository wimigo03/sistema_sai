<div class="body body-table">
    <div class="form-group row">
        <div class="col-md-12 table-responsive">
            <table class="table display table-bordered responsive" style="width:100%;">
                <thead>
                    <tr class="font-verdana">
                        <td class="text-center p-1"><b>CODIGO</b></td>
                        <td class="text-left p-1"><b>NOMBRE</b></td>
                        <td class="text-center p-1"><b>TIPO</b></td>
                        <td class="text-center p-1"><b>DISTRITO</b></td>
                        <td class="text-center p-1"><b>ESTADO</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barrios as $datos)
                        <tr class="font-verdana">
                            <td class="text-center p-1">{{ $datos->idBarrio }}</td>
                            <td class="text-left p-1">{{ $datos->barrio }}</td>
                            <td class="text-center p-1">{{ strtoupper($datos->tipo) }}</td>
                            <td class="text-center p-1">{{ $datos->distrito }}</td>
                            <td class="text-center p-1">{{ $datos->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-verdana">
                        <td colspan="12">
                            {{ $barrios->appends(Request::all())->links() }}
                            <p class="text-muted">Mostrando
                                <strong>{{$barrios->count()}}</strong> registros de
                                <strong>{{$barrios->total()}}</strong> totales
                            </p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>