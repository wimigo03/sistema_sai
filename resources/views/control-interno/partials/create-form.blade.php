<form action="#" method="post" id="form">
    @csrf
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="tipo_id" class="d-inline"><b>Tipo:</b></label>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <select name="tipo_id" id="tipo_id" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($tipos as $index => $value)
                    <option value="{{ $index }}" @if(old('tipo_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="codigo" class="d-inline"><b>Codigo:</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" oninput="this.value = this.value.toUpperCase()" class="form-control font-roboto-12 intro" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="numero" class="d-inline"><b>Numero:</b></label>
        </div>
        <div class="col-md-1 pr-1 pl-1">
            <input type="text" name="numero" id="numero" value="{{ old('numero') }}" class="form-control font-roboto-12 intro">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="destinatario" class="d-inline"><b>Solicitante:</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <select name="solicitante_id" id="solicitante_id" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($solicitantes as $index => $value)
                    <option value="{{ $index }}" @if(old('solicitante_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="destinatario" class="d-inline"><b>Dirigido a:</b></label>
        </div>
        <div class="col-md-7 pr-1 pl-1">
            <select name="destinatario_id" id="destinatario_id" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($destinatarios as $index => $value)
                    <option value="{{ $index }}" @if(old('destinatario_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="referencia" class="d-inline"><b>Referencia:</b></label>
        </div>
        <div class="col-md-6 pr-1 pl-1">
            <input type="text" name="referencia" id="referencia" value="{{ old('referencia') }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="fecha" class="d-inline"><b>Fecha:</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha" id="fecha" value="{{ old('fecha') ? old('fecha') : date('d/m/Y') }}" class="form-control font-roboto-12 intro" data-language="es">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="observaciones" class="d-inline"><b>Observaciones:</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <textarea name="observaciones" id="observaciones" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">{{ old('observaciones') }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 text-center">
            <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
            </span>
            <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
            </span>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
