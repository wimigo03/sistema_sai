<form action="#"  method="post" id="form">
    @csrf
    <input type="hidden" name="paquete_id" value="{{ $paquete_id }}" id="paquete_id">
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 pr-1 pl-1">
            <label for="distrito" class="d-inline"><b>Distrito</b></label>
            <select id="distrito_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($distritos as $index => $value)
                    <option value="{{ $index }}" @if(request('distrito_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <label for="barrio" class="d-inline"><b>Barrio</b></label>
            <select id="barrio_id" class="form-control select2">
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-4 pr-1 pl-1">
            <label for="lugar_entrega" class="d-inline"><b>Lugar de entrega</b></label>
            <input type="text" value="{{ old('lugar_entrega') }}" id="lugar_entrega" class="form-control font-roboto-12" data-language="es" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="fecha" class="d-inline"><b>Fecha de entrega</b></label>
            <input type="text" value="{{ old('fecha_entrega') }}" id="fecha_entrega" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="hora_inicio" class="d-inline"><b>Hora inicio</b></label>
            <input type="time" value="{{ old('hora_inicio') }}" class="form-control font-roboto-12" id="hora_inicio" step="60">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="hora_final" class="d-inline"><b>Hora final</b></label>
            <input type="time" value="{{ old('hora_final') }}" class="form-control font-roboto-12" id="hora_final" step="60">
        </div>
        <div class="col-md-2 pr-1 pl-1 text-right">
            <br>
            <span class="btn btn-success font-roboto-12" onclick="registrar();">
                <i class="fa-solid fa-plus fa-fw" aria-hidden="true"></i>
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 table-responsive">
            <table id="tabla_detalle" class="table display table-bordered responsive" style="width:100%;">
                <thead>
                    <tr class="font-roboto-11 bg-secondary text-white">
                        <td class="text-center p-1"><b>N°</b></td>
                        <td class="text-center p-1"><b>DISTRITO</b></td>
                        <td class="text-center p-1"><b>BARRIO</b></td>
                        <td class="text-center p-1"><b>LUGAR ENTREGA</b></td>
                        <td class="text-center p-1"><b>FECHA DE ENTREGA</b></td>
                        <td class="text-center p-1"><b>INICIO</b></td>
                        <td class="text-center p-1"><b>FINAL</b></td>
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-center">
            <br>
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();" id="btn-proceso">
                <i class="fa-solid fa-paper-plane fa-fw" aria-hidden="true"></i>&nbsp;Registrar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
