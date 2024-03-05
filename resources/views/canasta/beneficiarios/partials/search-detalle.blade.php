<div class="form-group row">
    <div class="col-md-2">
        <input type="text" name="nro_carnet" placeholder="--Nro Carnet--" value="{{request('nro_carnet')}}" class="form-control form-control-sm font-verdana-12">
    </div>
    <div class="col-md-3">
        <input type="text" name="nombres" placeholder="--Nombres--" value="{{request('nombres')}}" class="form-control form-control-sm font-verdana-12">
    </div>
    <div class="col-md-3">
        <input type="text" name="apellidos" placeholder="--Apellidos--" value="{{request('apellidos')}}" class="form-control form-control-sm font-verdana-12">
    </div>
    <div class="col-md-2">
        <input type="text" name="edad" placeholder="--Edad--" value="{{request('edad')}}" class="form-control form-control-sm font-verdana-12">
    </div>
    <div class="col-md-2">
        <input type="text" name="carnet_disc" placeholder="--Carnet Discapacidad--" value="{{request('carnet_disc')}}" class="form-control form-control-sm font-verdana-12">
    </div>
</div>
<div class="form-group row">
    <div class="col-md-3">
        <input type="text" name="barrio" placeholder="--Barrio--" value="{{request('barrio')}}" class="form-control form-control-sm font-verdana-12">
    </div>
    <div class="col-md-9 text-right">
        <button class="btn btn-danger font-verdana" type="button" onclick="searchdetallepdf();">
            &nbsp;<i class="fa fa-file-pdf" aria-hidden="true"></i>&nbsp;
        </button>
        <button class="btn btn-primary font-verdana" type="button" onclick="searchdetalle();">
            &nbsp;<i class="fa fa-search" aria-hidden="true"></i>&nbsp;
        </button>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
    </div>
</div>