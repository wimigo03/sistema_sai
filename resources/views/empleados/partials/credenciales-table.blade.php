<div class="form-group row">
    <div class="col-md-3 pr-1 pl-1">
        <input type="text" id="busqueda_nro_carnet" class="form-control font-roboto-12 text-center" onkeyup="search_nro_carnet();" placeholder="--Nro. carnet--">
    </div>
    <div class="col-md-9 pr-1 pl-1 text-right">
        <span class="btn btn-outline-success font-roboto-12" onclick="procesar();">
            <i class="fas fa-paper-plane fa-fw"></i> Generar credenciales
        </span>
        <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
            <i class="fas fa-times fa-fw"></i> Cancelar
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
<form action="#" method="get" id="form">
    <div class="form-group row abs-center">
        <div class="col-md-12 pr-1 pl-1 table-responsive">
            <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
                <thead>
                    <tr class="font-roboto-11">
                        <th class="text-center p-1">N° CARNET</th>
                        <th class="text-center p-1">NOMBRE COMPLETO</th>
                        <th class="text-center p-1">INGRESO</th>
                        <th class="text-left p-1">AREA - CARGO</th>
                        <th class="text-center p-1">TIPO</th>
                        <th class="text-center p-1">FOTO</th>
                        <th class="text-center p-1"><input type="checkbox" id="checkbox-general" class="checkbox-general"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $datos)
                        <tr class="font-roboto-11 fila {{ $datos->idemp }}">
                            <td class="text-left p-1 nro_carnet">{{ $datos->ci . ' ' . $datos->extension}}</td>
                            <td class="text-left p-1">{{ $datos->nombres . ' ' . $datos->ap_pat . ' ' . $datos->ap_mat }}</td>
                            <td class="text-center p-1">{{ $datos->ultimo_contrato_ingreso != null ? \Carbon\Carbon::parse($datos->ultimo_contrato_ingreso)->format('d/m/y') : '' }}</td>
                            <td class="text-left p-1">{{ $datos->area->nombrearea . ' - ' . $datos->file_cargo }}</td>
                            <td class="text-center p-1">{{ $datos->ultimo_tipo_contrato }}</td>
                            <td class="text-center p-1">{{ $datos->url_foto != null ? 'Si' : 'No' }}</td>
                            <td class="text-center p-1">
                                <input type="checkbox" class="checkbox-item" name="print[]" value="{{ $datos->idemp }}" {{ old('print') == '1' ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
