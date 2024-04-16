<div class="form-group row">
    <div class="col-md-4">
        <select name="periodo" id="periodo" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
            <option value="">-</option>
            <option value="1" @if(request('periodo') == '1') selected @endif>ENERO - FEBRERO - MARZO</option>
            <option value="2" @if(request('periodo') == '2') selected @endif>ABRIL - MAYO - JUNIO</option>
            <option value="3" @if(request('periodo') == '3') selected @endif>JULIO - AGOSTO - SEPTIEMBRE</option>
            <option value="4" @if(request('periodo') == '4') selected @endif>OCTUBRE - NOVIEMBRE - DICIEMBRE</option>
        </select>
    </div>
    <div class="col-md-2">
        <input type="text" name="anho" value="{{request('anho')}}" placeholder="--Gestion--" class="form-control form-control-sm font-verdana-12" id="anho" onkeypress="return valideNumberSinDecimal(event);">
    </div>
    <div class="col-md-6 text-right">
        <button class="btn btn-primary font-verdana-12" type="button" onclick="search();">
            <i class="fa fa-search" aria-hidden="true"></i>
            &nbsp;Buscar Pendientes
        </button>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
    </div>
</div>