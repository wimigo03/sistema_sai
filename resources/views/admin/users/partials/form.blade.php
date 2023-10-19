<form action="#" method="post" id="form">
    @csrf
    <input id="estadouser" hidden type="text" name="estadouser" value="1" >
    <div class="form-group row font-verdana-bg">
        <label for="role_id" class="required col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>
        <div class="col-md-6" id="permissions-select">
            <select id="role_id" type="text" class="form-control @error('role_id') is-invalid @enderror select2" name="role_id" required autocomplete="role_id" autofocus>
                <option value="" selected hidden>-</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ strtoupper($role->title) }} </option>
                @endforeach
            </select>
            @error('role_id')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <label for="idemp" class="required col-md-4 col-form-label text-md-right">{{ __('Empleado') }}</label>
        <div class="col-md-6" id="permissions-select2">
            <select id="idemp" type="text" class="form-control @error('idemp') is-invalid @enderror select2"" name="idemp" required autocomplete="idemp" autofocus>
                <option value="" selected hidden>-</option>
                @foreach ($empleados as $empleado)
                    <option value="{{$empleado->idemp}}">
                        {{$empleado->nombres}} {{$empleado->ap_pat}} {{$empleado->ap_mat}}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
        <div class="col-md-6">
            <input id="name" type="text" class="form-control font-verdana-bg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <label for="email" class="required col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
        <div class="col-md-6">
            <input id="email" type="email" class="form-control font-verdana-bg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <label for="password" class="required col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
        <div class="col-md-6">
            <input id="password" type="password" class="form-control font-verdana-bg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <label for="password-confirm" class="required col-md-4 col-form-label text-md-right">{{ __('Confirmar Password') }}</label>
        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control font-verdana-bg" name="password_confirmation" required autocomplete="new-password">
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-12 text-center">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="store();">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Registrar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>