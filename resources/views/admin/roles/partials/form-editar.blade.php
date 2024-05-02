<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="role_id" value="{{ $role->id }}">
    <div class="form-group row font-roboto-12">
        <div class="col-md-5 pr-1 pl-1">
            <label for="unidad" class="d-inline"><b>Direccion Administrativa</b></label>
            <select name="dea_id" id="dea_id" class="form-control font-roboto-12 select2">
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
    <div class="form-group row font-roboto-12">
        <div class="col-md-3 pr-1 pl-1">
            <label for="titulo" class="d-inline"><b>Titulo</b></label>
            <input type="text" name="titulo" value="{{ $role->title }}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="codigo" class="d-inline"><b>Codigo</b></label>
            <input type="text" name="codigo" value="{{ $role->short_code }}" class="form-control font-roboto-12 intro">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1" id="permissions-select">
            <label for="permissions" class="d-inline"><b>Permisos</b></label>
            <select name="permissions[]" id="permissions" class="@error('permissions') is-invalid @enderror"  multiple>
                @foreach ($permissions as $id => $permission)
                    <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permission }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1" id="permissions-select">
            <a href="#" id="permission-select-all" class="btn btn-info font-roboto-12">
                <i class="fa-solid fa-fw fa-list-check"></i>&nbsp;Seleccionar todo
            </a>
            <a href="#" id="permission-deselect-all" class="btn btn-info font-roboto-12">
                <i class="fa-solid fa-fw fa-list"></i>&nbsp;Quitar seleccion
            </a>
        </div>
    </div>

    {{--<div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1" id="permissions-select">
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
    </div>--}}

    <div class="form-group row">
        <div class="col-md-12 text-right">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                <i class="fa-solid fa-paper-plane fa-fw"></i>&nbsp;Registrar
            </button>
            <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
