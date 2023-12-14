<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="role_id" value="{{ $role->id }}">
    <div class="form-group row font-verdana-bg">
        <div class="col-md-5 pr-1">
            <label for="unidad" class="d-inline">Direccion Administrativa</label>
            <select name="dea_id" id="dea_id" class="form-control form-control-sm select2">
                @foreach ($deas as $dea)
                    <option value="{{ $dea->id }}"
                        @if($dea->id == request('dea_id') || (isset($role) && $role->dea_id == $dea->id))
                            selected
                        @endif>
                        {{ $dea->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-3 pr-1">
            <label for="titulo" class="d-inline">Titulo</label>
            <input type="text" name="titulo" value="{{ $role->title }}" class="form-control form-control-sm font-verdana intro">
        </div>
        <div class="col-md-3 pr-1">
            <label for="codigo" class="d-inline">Codigo</label>
            <input type="text" name="codigo" value="{{ $role->short_code }}" class="form-control form-control-sm font-verdana-bg intro">
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-12" id="permissions-select">
            <div class="row">
                <div class="col-md-6">
                    <label for="permissions" class="d-inline">Permisos</label>
                </div>
                <div class="col-md-6 text-right">
                    <a href="#" id="permission-select-all" class="text-dark">
                        <i class="fa-solid fa-list-check"></i>&nbsp;Seleccionar todo
                    </a>
                    &nbsp;
                    <a href="#" id="permission-deselect-all" class="text-dark">
                        <i class="fa-solid fa-list"></i>&nbsp;Quitar seleccion
                    </a>
                </div>
            </div>
            <select name="permissions[]" id="permissions" class="@error('permissions') is-invalid @enderror"  multiple>
                @foreach ($permissions as $id => $permission)
                    <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permission }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fa-solid fa-paper-plane"></i>&nbsp;Actualizar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                <i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
