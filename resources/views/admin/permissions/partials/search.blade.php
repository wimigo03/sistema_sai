<form action="#" method="get" id="form">
    {{--<div class="form-group row">
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="codigo_id" placeholder="--Codigo Id--" value="{{ request('codigo_id') }}" class="form-control font-roboto-12 intro" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="dea_id" id="dea_id" class="form-control">
                <option value="">-</option>
                @foreach ($unidades as $index => $value)
                    <option value="{{ $index }}" @if(request('dea_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="titulo" placeholder="--Titulo--" value="{{ request('titulo') }}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="codigo" placeholder="--Codigo--" value="{{ request('codigo') }}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>--}}
    <div class="form-group row">
        <div class="col-md-6 pr-1 pl-1">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Crear">
                <button class="btn btn-outline-success font-roboto-12" type="button" onclick="create();">
                    <i class="fa fa-plus"></i>
                </button>
                <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </span>
        </div>
        {{--<div class="col-md-6 pr-1 pl-1 text-right">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                <i class="fa fa-search" aria-hidden="true"></i> Buscar
            </button>
            <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="limpiar();">
                <i class="fa fa-eraser"></i> Limpiar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>--}}
    </div>
</form>
