<div class="form-group row font-roboto-12 align-items-center">
    <div class="col-md-4 pr-1 pl-1 text-right">
        <label for="tipo" class="d-inline"><b>Tipo:</b></label>
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <select name="tipo" id="tipo" class="form-control select2">
            <option value="">-</option>
            @foreach ($tipos as $index => $value)
                <option value="{{ $index }}" @if(isset($ocupacion->tipo) ? $ocupacion->tipo : old('tipo') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row font-roboto-12 align-items-center">
    <div class="col-md-4 pr-1 pl-1 text-right">
        <label for="detalle" class="d-inline"><b>Detalle:</b></label>
    </div>
    <div class="col-md-4 pr-1 pl-1">
        <input type="text" name="detalle" id="detalle" value="{{ isset($ocupacion->ocupacion) ? $ocupacion->ocupacion : old('detalle') }}" oninput="this.value = this.value.toUpperCase()" class="form-control font-verdana-12 intro">
    </div>
</div>
