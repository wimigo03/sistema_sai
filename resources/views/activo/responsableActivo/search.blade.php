<form action="#" method="get" id="form">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span>
            <b>UNIDAD: </b>{{ $unidad->descrip }}
        </span>
    </div>
    <div class="row">
        <div class="col-md-2 form-group">
            <input type="text" name="codigo" value="{{ request('codigo') }}" placeholder="--Codigo--"
            class="form-control font-verdana">
        </div>
        <div class="col-md-2 form-group">
            <input type="text" name="grupo" value="{{ request('grupo') }}" placeholder="--Grupo Contable--"
            class="form-control font-verdana">
        </div>
        <div class="col-md-2 form-group">
            <input type="text" name="auxiliar" value="{{ request('auxiliar') }}" placeholder="--Auxiliar--"
            class="form-control font-verdana">
        </div>
        <div class="col-md-2 form-group">
            <input type="text" name="ambiente" value="{{ request('ambiente') }}" placeholder="--Ambiente--"
            class="form-control font-verdana">
        </div>
        <div class="col-md-2 form-group">
            <select name="estado" id="estado" class="form-control">
                <option value="">-Estado-</option>
                <option value="1" @if (request('estado') == '1') selected @endif>BUENO</option>
                <option value="2" @if (request('estado') == '2') selected @endif>REGULAR</option>
                <option value="3" @if (request('estado') == '3') selected @endif>MALO</option>
            </select>
        </div>
        <div class="col-md-2 form-group">
            <select name="kardex" id="kardex" class="form-control">
                <option value="">-Kardex-</option>
                <option value="1" @if (request('kardex') == '1') selected @endif>CON KARDEX</option>
                <option value="0" @if (request('kardex') == '0') selected @endif>SIN KARDEX</option>
            </select>
        </div>
        <div class="col-md-2 form-group">
            <input type="text" name="cod_rube" value="{{ request('cod_rube') }}" placeholder="--Preventivo--"
            class="form-control font-verdana">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mt-3">
            
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
