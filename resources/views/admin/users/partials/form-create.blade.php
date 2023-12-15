<form action="#" method="post" id="form">
    @csrf
    <div class="form-group row font-verdana-bg">
        <div class="col-md-6 pr-1">
            <label for="empleado_id" class="d-inline">Empleado</label>
            <select name="idemp" id="idemp" class="form-control form-control-sm select2" required autocomplete="idemp" autofocus>
                <option value="">-</option>
                @foreach ($empleados as $index => $value)
                    <option value="{{ $index }}" @if(old('idemp') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 pl-1">
            <label for="name" class="d-inline">Nombre de usuario</label>
            <input type="text" name="name" value="{{ request('name') }}" class="form-control form-control-sm font-verdana-bg intro">
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-3 pr-1">
            <label for="email" class="d-inline">E-Mail</label>
            <input type="text" name="email" value="{{ old('email') }}" class="form-control form-control-sm font-verdana-bg intro">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="password" class="d-inline">Password</label>
            <input type="password" name="password" value="{{ old('password') }}" class="form-control form-control-sm font-verdana-bg intro" required autocomplete="new-password">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="password-confirm" class="d-inline">Confirmar-Password</label>
            <input id="password-confirm" type="password" class="form-control font-verdana-bg intro" name="password_confirmation" required autocomplete="new-password">
        </div>
        <div class="col-md-3 pl-1">
            <label for="dea" class="d-inline">DEA</label>
            <select name="dea" id="dea" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($deas as $index => $value)
                    <option value="{{ $index }}" @if(old('dea') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-12 pr-1" id="permissions-select">
            <label for="roles" class="d-inline">Roles</label>
            <select name="roles[]" id="roles" class="@error('roles') is-invalid @enderror"  multiple>
                @foreach ($roles as $id => $rol)
                    <option value="{{ $id }}" {{ (in_array($id, old('roles', []))) ? 'selected' : '' }}>{{ $rol }}</option>
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
                &nbsp;<i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
