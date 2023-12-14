<form action="#" method="post" id="form">
    @csrf
    <div class="form-group row font-verdana-bg">
        <div class="col-md-5 pr-1">
            <label for="unidad" class="d-inline">Direccion Administrativa</label>
            <select name="dea_id" id="dea_id" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($deas as $index => $value)
                    <option value="{{ $index }}" @if(request('dea_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-3 pr-1">
            <label for="titulo" class="d-inline">Titulo</label>
            <input type="text" name="titulo" value="{{ old('titulo') }}" class="form-control form-control-sm font-verdana intro">
        </div>
        <div class="col-md-3 pr-1">
            <label for="codigo" class="d-inline">Codigo</label>
            <input type="text" name="codigo" value="{{ old('codigo') }}" class="form-control form-control-sm font-verdana-bg intro">
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-12 pr-1" id="permissions-select">
            <label for="permissions" class="d-inline">Permisos</label>
            <select name="permissions[]" id="permissions" class="@error('permissions') is-invalid @enderror"  multiple>
                @foreach ($permissions as $id => $permission)
                    <option value="{{ $id }}" {{ (in_array($id, old('permissions', []))) ? 'selected' : '' }}>{{ $permission }}</option>
                @endforeach
            </select>
            <a href="#" id="permission-select-all" class="btn btn-sm btn-link font-verdana-bg">
                <i class="fa-solid fa-lg fa-list-check"></i>&nbsp;Seleccionar todo
            </a>
            <a href="#" id="permission-deselect-all" class="btn btn-sm btn-link font-verdana-bg">
                <i class="fa-solid fa-lg fa-list"></i>&nbsp;Quitar seleccion
            </a>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fa-solid fa-paper-plane"></i>&nbsp;Registrar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                <i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
