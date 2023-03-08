<div class="form-group row">
    <div class="col-md-2">
        <input type="text" name="nro_carnet" placeholder="--Nro Carnet--" value="{{request('nro_carnet')}}" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-4">
        <input type="text" name="nombres" placeholder="--Nombres--" value="{{request('nombres')}}" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-4">
        <input type="text" name="apellidos" placeholder="--Apellidos--" value="{{request('apellidos')}}" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <input type="text" name="edad" placeholder="--Edad--" value="{{request('edad')}}" class="form-control form-control-sm font-verdana-bg">
    </div>
</div>
<div class="form-group row">
    <div class="col-md-5">
        <input type="text" name="barrio" placeholder="--Barrio--" value="{{request('barrio')}}" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-3">
        <input type="text" name="carnet_disc" placeholder="--Carnet Discapacidad--" value="{{request('carnet_disc')}}" class="form-control form-control-sm font-verdana-bg">
    </div>
    <div class="col-md-2">
        <input type="text" name="fecha_desde" value="" placeholder="--Desde--" value="{{request('fecha_desde')}}" class="form-control form-control-sm font-verdana-bg" id="fecha_desde" data-language="es" autocomplete="off">
    </div>
    <div class="col-md-2">
        <input type="text" name="fecha_hasta" value="" placeholder="--Hasta--" value="{{request('fecha_hasta')}}" class="form-control form-control-sm font-verdana-bg" id="fecha_hasta" data-language="es" autocomplete="off">
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12 text-right">
        <button class="btn btn-primary font-verdana" type="button" onclick="search();">
            <i class="fa fa-search" aria-hidden="true"></i>
            &nbsp;Buscar
        </button>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
    </div>
</div>