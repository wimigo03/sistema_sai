<div class="body body-table">
    @if (isset($historial_bajas) && count($historial_bajas) > 0)
        <div class="form-group row font-verdana-12">
            <div class="col-md-12 text-center">
                <b>BAJAS</b>
            </div>
            <div class="col-md-12 table-responsive">
                <table class="table display table-bordered responsive" style="width:100%;">
                    <thead>
                        <tr class="font-verdana-sm">
                            <td class="text-left p-1"><b>CODIGO</b></td>
                            <td class="text-left p-1"><b>IP</b></td>
                            <td class="text-center p-1"><b>FECHA</b></td>
                            <td class="text-left p-1"><b>OBSERVACIONES</b></td>
                            <td class="text-center p-1"><b>ESTADO</b></td>
                            <td class="text-left p-1"><b>USUARIO</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historial_bajas as $datos)
                            <tr class="font-verdana-sm">
                                <td class="text-left p-1">{{ $datos->idHistorialBaja }}</td>
                                <td class="text-left p-1">{{ $datos->ip }}</td>
                                <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                                <td class="text-left p-1">{{ $datos->obs }}</td>
                                <td class="text-center p-1">{{ $datos->estado }}</td>
                                <td class="text-left p-1">{{ $datos->admin->nombre_completo }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    @if (isset($historial_mod) && count($historial_mod) > 0)
        <div class="form-group row font-verdana-12">
            <div class="col-md-12 text-center">
                <b>MODIFICACIONES</b>
            </div>
            <div class="col-md-12 table-responsive">
                <table class="table display table-bordered responsive" style="width:100%;">
                    <thead>
                        <tr class="font-verdana-sm">
                            <td class="text-left p-1"><b>CODIGO</b></td>
                            <td class="text-left p-1"><b>IP</b></td>
                            <td class="text-center p-1"><b>FECHA</b></td>
                            <td class="text-left p-1"><b>OBSERVACIONES</b></td>
                            <td class="text-center p-1"><b>ESTADO</b></td>
                            <td class="text-left p-1"><b>USUARIO</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historial_mod as $datos)
                            <tr class="font-verdana-sm">
                                <td class="text-left p-1">{{ $datos->idHistorialMod }}</td>
                                <td class="text-left p-1">{{ $datos->ip }}</td>
                                <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                                <td class="text-left p-1">{{ strtoupper($datos->observacion) }}</td>
                                <td class="text-center p-1">{{ $datos->estado }}</td>
                                <td class="text-left p-1">{{ $datos->admin->nombre_completo }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>