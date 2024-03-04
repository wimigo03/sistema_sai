<form action="#" method="get" id="form">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span>
            <b>UNIDAD: </b>{{ $unidad->descrip }}
        </span>
    </div>
    <div class="form-group row">
        <div class="col-md-3">
            <input type="text" name="ci" value="{{ request('ci') }}" placeholder="--CI Responsable--"
                class="form-control font-verdana">
        </div>
        <div class="col-md-3">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="--Nombres Responsable--"
                class="form-control font-verdana">
        </div>
        <div class="col-md-3">
            <input type="text" name="ap_pat" value="{{ request('ap_pat') }}" placeholder="--Ap. Paterno--"
                class="form-control font-verdana">
        </div>
        <div class="col-md-3">
            <input type="text" name="ap_mat" value="{{ request('ap_mat') }}" placeholder="--Ap. Materno--"
                class="form-control font-verdana">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3">
            <input type="text" name="oficina" value="{{ request('oficina') }}" placeholder="--Oficina--"
                class="form-control font-verdana">
        </div>
        <div class="col-md-3">
            <input type="text" name="cargo" value="{{ request('cargo') }}" placeholder="--Cargo Responsable--"
                class="form-control font-verdana">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            @can('actual_create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Crear Nuevo Activo">
                    <button class="btn btn-sm btn-success font-verdana" type="button" onclick="create();">
                        &nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </span>
                <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn" style="display: none;"></i>
            @endcan
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary font-verdana" type="button" onclick="search();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-danger font-verdana text-white" type="button" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
