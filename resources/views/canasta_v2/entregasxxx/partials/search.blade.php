<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="gestion" placeholder="-- Gestion --" value="{{request('gestion')}}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="periodo" placeholder="-- Periodo --" value="{{request('periodo')}}" class="form-control font-roboto-12 intro">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            @can('canasta.entregas.paquete.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Crear">
                    <button class="btn btn-outline-success font-roboto-12" type="button" onclick="create();">
                        <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                    </button>
                </span>
            @endcan
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
