<form action="#" method="post" id="form">
    @csrf
    <input id="estadouser" hidden type="text" name="estadouser" value="1" >
    <div class="form-group row font-verdana-bg">
        <div class="col-md-4 pr-1">
            <label for="role_id" class="d-inline"><b>Rol</b></label><br>
            <select name="role_id" id="role_id" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($roles as $index => $value)
                    <option value="{{ $index }}" @if(request('role_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        {{--<div class="col-md-5 pr-1 pl-1">
            <label for="idemp" class="d-inline"><b>Empleado</b></label><br>
            <select name="idemp" id="idemp" class="form-control form-control-sm select2">
                <option value="">-</option>
                @foreach ($empleados as $index => $value)
                    <option value="{{ $index }}" @if(request('idemp') == $index) selected @endif >{{ $value }}</option>--}}
    </div>
    {{--<div class="form-group row font-verdana-bg">
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
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-5 pr-1">
            <label for="name" class="d-inline"><b>Nombre(s)</b></label><br>
            <input type="text" name="name" value="{{request('name')}}" class="form-control form-control-sm font-verdana-bg">
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <label for="email" class="d-inline"><b>E-Mail</b></label><br>
            <input type="text" name="email" value="{{request('email')}}" class="form-control form-control-sm font-verdana-bg">
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <label for="password" class="required">{{ __('Password') }}</label>
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
        <label for="password-confirm" class="required">{{ __('Confirmar Password') }}</label>
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
    </div>--}}
</form>