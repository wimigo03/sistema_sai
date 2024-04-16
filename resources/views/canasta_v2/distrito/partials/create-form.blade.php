<form action="#" method="post" id="form">
    @csrf
    <div class="form-group row font-verdana-12">
        <div class="col-md-4 pr-1">
            <label for="nombre" class="d-inline">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{old('nombre')}}" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm font-verdana-12 intro {{ $errors->has('nombre') ? ' is-invalid' : '' }}">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="dea" class="d-inline">DEA</label>
            <select name="dea" id="dea" class="form-control form-control-sm select2 {{ $errors->has('dea_id') ? ' is-invalid' : '' }}">
                <option value="">-</option>
                @foreach ($deas as $index => $value)
                    <option value="{{ $index }}" @if(old('dea') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                &nbsp;<i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
