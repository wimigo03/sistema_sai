<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="_form" value="1">
    <div class="form-group row font-roboto-12">
        <div class="col-md-3 pr-1 pl-1">
            <label for="dea" class="d-inline"><b>Direccion Administrativa</b></label>
            <input type="hidden" name="dea" value="{{ $dea->id }}" class="form-control font-roboto-12">
            <input type="text" value="{{ $dea->descripcion }}" class="form-control font-roboto-12">
        </div>
        <div class="col-md-6 pr-1 pl-1 font-roboto-12">
            <label for="area" class="d-inline"><b>Area</b></label>
            <input type="hidden" name="area_id" value="{{ $empleado->idarea }}">
            <input type="text" value="{{ $empleado->area->nombrearea }}" class="form-control font-roboto-12">
        </div>
        <div class="col-md-3 pr-1 pl-1 font-roboto-12">
            <label for="empleado" class="d-inline"><b>Empleado</b></label>
            <input type="hidden" name="empleado_id" value="{{ $empleado->idemp }}">
            <input type="text" value="{{ $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat }}" class="form-control font-roboto-12">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-3 pr-1 pl-1">
            <label for="name" class="d-inline"><b>Nombre de usuario</b></label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="email" class="d-inline"><b>E-Mail</b></label>
            <input type="text" name="email" value="{{ old('email') }}" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="password" class="d-inline"><b>Password</b></label>
            <input type="password" name="password" value="{{ old('password') }}" class="form-control font-roboto-12 intro" required autocomplete="new-password">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="password-confirm" class="d-inline"><b>Confirmar-Password</b></label>
            <input id="password-confirm" type="password" class="form-control font-roboto-12 intro" name="password_confirmation" required autocomplete="new-password">
            <input type="hidden" name="_email" id="_email">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1" id="permissions-select">
            <label for="roles" class="d-inline"><b>Asignacion de Roles</b></label>
            <select name="roles[]" id="roles" class="@error('roles') is-invalid @enderror"  multiple>
                @foreach ($roles as $id => $rol)
                    <option value="{{ $id }}" {{ (in_array($id, old('roles', []))) ? 'selected' : '' }}>{{ $rol }}</option>
                @endforeach
            </select>
            {{--<a href="#" id="permission-select-all" class="btn btn-sm btn-link font-roboto-12">
                <i class="fa-solid fa-lg fa-list-check"></i>&nbsp;Seleccionar todo
            </a>--}}
            {{--<a href="#" id="permission-deselect-all" class="btn btn-sm btn-link font-roboto-12">
                <i class="fa-solid fa-lg fa-list"></i>&nbsp;Quitar seleccion
            </a>--}}
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-6 pr-1 pl-1" id="permissions-select">
            <a href="#" id="permission-select-all" class="btn btn-outline-info font-roboto-12">
                <i class="fa-solid fa-list-check fa-fw"></i>&nbsp;Seleccionar todo
            </a>
            <a href="#" id="permission-deselect-all" class="btn btn-outline-info font-roboto-12">
                <i class="fa-solid fa-list fa-fw"></i>&nbsp;Quitar seleccion
            </a>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                <i class="fa-solid fa-paper-plane"></i>&nbsp;Registrar
            </button>
            <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                <i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
