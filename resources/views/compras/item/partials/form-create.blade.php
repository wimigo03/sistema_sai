<form action="#" method="post" id="form">
    @csrf
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="partida_presupuestaria_id" class="d-inline"><b>Partida Presupuestaria :</b></label>
        </div>
        <div class="col-md-7 pr-1 pl-1">
            <select name="partida_presupuestaria_id" id="partida_presupuestaria_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($partidas_presupuestarias as $index => $value)
                    <option value="{{ $index }}" @if(old('partida_presupuestaria_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="numeracion" class="d-inline"><b>Numeracion :</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="numeracion" id="numeracion" value="{{ old('numeracion') }}" class="form-control font-roboto-12 numero-entero">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="nombre" class="d-inline"><b>Nombre :</b></label>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="unidad_id" class="d-inline"><b>Unidad de Medida :</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="unidad_id" id="unidad_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($unidades as $index => $value)
                    <option value="{{ $index }}" @if(old('unidad_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="precio" class="d-inline"><b>Precio Referencial :</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="precio" value="0{{-- old('precio') --}}" id="precio" class="form-control font-roboto-12 input-numero-cleave">
        </div>
    </div>
    {{--<div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="tipo" class="d-inline"><b>Tipo: </b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="tipo" id="tipo" class="form-control select2">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>--}}
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-3 pr-1 pl-1 text-right">
            <label for="detalle" class="d-inline"><b>Descripcion :</b></label>
        </div>
        <div class="col-md-7 pr-1 pl-1">
            <textarea name="detalle" id="detalle" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">{{ old('detalle') }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-right">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fas fa-paper-plane fa-fw"></i> Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fas fa-times fa-fw"></i> Cancelar
            </span>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
