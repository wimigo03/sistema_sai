<form action="#"  method="post" id="form">
    @csrf
    <input type="hidden" value="{{ $paquete_barrio->id_paquete }}" id="paquete_id">
    <input type="hidden" name="paquete_barrio_id" value="{{ $paquete_barrio->id }}" id="paquete_barrio_id">
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 pr-1 pl-1">
            <label for="distrito" class="d-inline"><b>Distrito</b></label>
            <input type="text" value="{{ $paquete_barrio->distrito->nombre }}" class="form-control font-roboto-12" disabled>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <label for="barrio" class="d-inline"><b>Barrio</b></label>
            <input type="text" value="{{ $paquete_barrio->barrio->nombre }}" class="form-control font-roboto-12" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-4 pr-1 pl-1">
            <label for="lugar_entrega" class="d-inline"><b>Lugar de entrega</b></label>
            <input type="text" value="{{ $paquete_barrio->lugar_entrega }}" name="lugar_entrega" id="lugar_entrega" class="form-control font-roboto-12" data-language="es" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="fecha" class="d-inline"><b>Fecha de entrega</b></label>
            <input type="text" value="{{ $paquete_barrio->fecha_entrega != null ? \Carbon\Carbon::parse($paquete_barrio->fecha_entrega)->format('d/m/Y') : '' }}" name="fecha_entrega" id="fecha_entrega" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="hora_inicio" class="d-inline"><b>Hora inicio</b></label>
            <input type="time" value="{{ $paquete_barrio->hora_inicio }}" class="form-control font-roboto-12" name="hora_inicio" id="hora_inicio" step="60">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="hora_final" class="d-inline"><b>Hora final</b></label>
            <input type="time" value="{{ $paquete_barrio->hora_final }}" class="form-control font-roboto-12" name="hora_final" id="hora_final" step="60">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-center">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fa-solid fa-paper-plane fa-fw" aria-hidden="true"></i>&nbsp;Registrar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
