<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1">
            <input type="text" name="codigo_id" placeholder="--Codigo ID--" value="{{ request('codigo_id') }}" class="form-control form-control-sm font-verdana-bg intro" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-2 pr-1">
            <input type="text" name="control_interno" placeholder="--N° Control Interno--" value="{{ request('control_interno') }}" class="form-control form-control-sm font-verdana-bg intro" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-8 pl-1">
            <input type="text" name="objeto" placeholder="--Objeto--" value="{{ request('objeto') }}" class="form-control form-control-sm font-verdana-bg intro">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="create();">
                &nbsp;<i class="fa fa-plus"></i>&nbsp;Crear
            </button>
            <button class="btn btn-outline-info font-verdana" type="button" onclick="responsables();">
                <i class="fa-solid fa-users"></i>&nbsp;Responsables
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="limpiar();">
                &nbsp;<i class="fa fa-eraser"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
    </div>
</form>
