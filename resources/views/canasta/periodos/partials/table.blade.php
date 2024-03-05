<div class="body body-table">
    <div class="form-group row">
        <div class="col-md-12 table-responsive">
            <table class="table display table-bordered responsive" style="width:100%;">
                <thead>
                    <tr class="font-verdana-11">
                        <td class="text-center p-1"><b>PERIODO</b></td>
                        <td class="text-center p-1"><b>GESTION</b></td>
                        <td class="text-center p-1"><b>MES</b></td>
                        <td class="text-center p-1"><b>NRO. ENT.</b></td>
                        <td class="text-left p-1"><b>OBS.</b></td>
                        <td class="text-center p-1"><b>ESTADO</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periodos as $datos)
                        <tr class="font-verdana-11">
                            <td class="text-center p-1">{{ $datos->idPeriodo }}</td>
                            <td class="text-center p-1">{{ $datos->gestion }}</td>
                            <td class="text-center p-1">{{ $datos->mes }}</td>
                            <td class="text-center p-1">{{ $datos->nro_entrega }}</td>
                            <td class="text-left p-1">{{ $datos->obs }}</td>
                            <td class="text-center p-1">{{ $datos->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-verdana-11">
                        <td colspan="12">
                            {{ $periodos->appends(Request::all())->links() }}
                            <p class="text-muted">Mostrando
                                <strong>{{$periodos->count()}}</strong> registros de
                                <strong>{{$periodos->total()}}</strong> totales
                            </p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>