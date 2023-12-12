<form action="#" method="post" id="form">
    @csrf
    <input id="estadouser" hidden type="text" name="estadouser" value="1" >
    <div class="form-group row font-verdana-bg">
        <div class="col-md-4 pr-1">
            <label for="role_id" class="d-inline">Rol</label>
            <select name="role_id" id="role_id" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($roles as $index => $value)
                    <option value="{{ $index }}" @if(request('role_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pl-1">
            <label for="empleado_id" class="d-inline">Empleado</label>
            <select name="idemp" id="idemp" class="form-control form-control-sm select2" required autocomplete="idemp" autofocus>
                <option value="">-</option>
                @foreach ($empleados as $index => $value)
                    <option value="{{ $index }}" @if(request('idemp') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-5 pr-1">
            <label for="name" class="d-inline">Nombre(s)</label>
            <input type="text" name="name" value="{{ request('name') }}" class="form-control form-control-sm font-verdana-bg intro">
        </div>
        <div class="col-md-5 pl-1">
            <label for="email" class="d-inline">E-Mail</label>
            <input type="text" name="email" value="{{ request('email') }}" class="form-control form-control-sm font-verdana-bg intro">
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-4 pr-1">
            <label for="password" class="d-inline">Password</label>
            <input type="password" name="password" value="{{ request('password') }}" class="form-control form-control-sm font-verdana-bg intro" required autocomplete="new-password">
        </div>
        <div class="col-md-4 pl-1">
            <label for="password-confirm" class="d-inline">Confirmar Password</label>
            <input id="password-confirm" type="password" class="form-control font-verdana-bg intro" name="password_confirmation" required autocomplete="new-password">
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