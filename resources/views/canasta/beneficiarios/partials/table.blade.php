<div class="body body-table">
    <div class="form-group row">
        <div class="col-md-12 table-responsive">
            <table class="table display table-bordered responsive" style="width:100%;">
                <thead>
                    <tr class="font-verdana">
                        <td class="text-left p-1"><b>CODIGO</b></td>
                        <td class="text-left p-1"><b>NOMBRES</b></td>
                        <td class="text-left p-1"><b>AP. PATERNO</b></td>
                        <td class="text-left p-1"><b>AP. MATERNO</b></td>
                        <td class="text-left p-1"><b>NRO CARNET</b></td>
                        <td class="text-center p-1"><b>NATALICIO</b></td>
                        <td class="text-center p-1"><b>EDAD</b></td>
                        <td class="text-center p-1"><b>SEXO</b></td>
                        <td class="text-center p-1"><b>DISTRITO</b></td>
                        <td class="text-left p-1"><b>BARRIO</b></td>
                        <td class="text-center p-1"><b>ESTADO</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beneficiarios as $datos)
                        <tr class="font-verdana">
                            <td class="text-left p-1">{{ $datos->idUsuario }}</td>
                            <td class="text-left p-1">{{ $datos->nombres }}</td>
                            <td class="text-left p-1">{{ $datos->ap }}</td>
                            <td class="text-left p-1">{{ $datos->am }}</td>
                            <td class="text-left p-1">{{ $datos->ci . ' - ' . $datos->expedido }}</td>
                            <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fechaNac)->format('d/m/Y') }}</td>
                            <td class="text-center p-1">{{ $datos->edad }}</td>
                            <td class="text-center p-1">{{ $datos->sexo }}</td>
                            <td class="text-center p-1">{{ $datos->barrios->distrito }}</td>
                            <td class="text-left p-1">{{ $datos->barrios->barrio }}</td>
                            <td class="text-center p-1">{{ $datos->estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-verdana">
                        <td colspan="12">
                            {{ $beneficiarios->appends(Request::all())->links() }}
                            <p class="text-muted">Mostrando
                                <strong>{{$beneficiarios->count()}}</strong> registros de
                                <strong>{{$beneficiarios->total()}}</strong> totales
                            </p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>