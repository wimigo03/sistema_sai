@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MI PERFIL</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <img src="{{ asset($empleado->url_foto) }}" alt="Sin foto de perfil" style="width-min: 100px; width: 250px; height: auto; border-radius: 5%;">
            </div>
        </div>
        <div class="card card-body">
            <div class="form-group row font-roboto-12">
                <div class="col-md-3 pr-1 pl-1">
                    <label for="nombre" class="d-inline"><b>Nombre (s)</b></label>
                    <input type="text" value="{{ $empleado->nombres }}" class="form-control font-roboto-12" disabled>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    <label for="apellido_paterno" class="d-inline"><b>Apellido Paterno</b></label>
                    <input type="text" value="{{ $empleado->ap_pat }}" class="form-control font-roboto-12" disabled>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    <label for="apellido_materno" class="d-inline"><b>Apellido Materno</b></label>
                    <input type="text" value="{{ $empleado->ap_mat }}" class="form-control font-roboto-12" disabled>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    <label for="usuario" class="d-inline"><b>Usuario</b></label>
                    <input type="text" value="{{ $user->name }}" class="form-control font-roboto-12" disabled>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-2 pr-1 pl-1">
                    <label for="nro_carnet" class="d-inline"><b>Nro. Carnet</b></label>
                    <input type="text" value="{{ $empleado->ci . ' ' . $empleado->extension }}" class="form-control font-roboto-12" disabled>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <label for="sexo" class="d-inline"><b>Sexo</b></label>
                    <input type="text" value="{{ $empleado->sexo_full }}" class="form-control font-roboto-12" disabled>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <label for="natalicio" class="d-inline"><b>Natalicio</b></label>
                    <input type="text" value="{{ $empleado->natalicio != null ? \Carbon\Carbon::parse($empleado->natalicio)->format('d/m/Y') : '' }}" class="form-control font-roboto-12" disabled>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    <label for="libreta_militar" class="d-inline"><b>N° Libreta Militar</b></label>
                    <input type="text" value="{{ $empleado->servmilitar }}" class="form-control font-roboto-12" disabled>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <label for="cuenta_banco" class="d-inline"><b>Cuenta Banco Union</b></label>
                    <input type="text" value="{{ $empleado->cuentabanco }}" class="form-control font-roboto-12" disabled>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-roboto-15">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <b>MODIFICAR CLAVE DE ACCESO</b>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="#" method="post" id="form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="form-group row font-roboto-12 abs-center">
                        <div class="col-md-3 pr-1 pl-1">
                            <label for="password" class="d-inline"><b>Password</b></label>
                            <input type="password" name="password" value="" class="form-control font-roboto-12 intro" required autocomplete="new-password">
                        </div>
                        <div class="col-md-3 pr-1 pl-1">
                            <label for="password-confirm" class="d-inline"><b>Confirmar-Password</b></label>
                            <input id="password-confirm" type="password" class="form-control font-roboto-12 intro" name="password_confirmation" required autocomplete="new-password">
                            <input type="hidden" name="_email" id="_email">
                        </div>
                    </div>
                    <div class="form-group row font-roboto-12 abs-center">
                        <div class="col-md-6 pr-1 pl-1 text-center">
                            <button class="btn btn-block btn-outline-warning font-roboto-12" type="button" onclick="procesar();">
                                <i class="fas fa-user-lock fa-fw"></i>&nbsp;Cambiar contraseña
                            </button>
                            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn" style="display: none;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "--Seleccionar--"
        });
    });

    $('.intro').on('keypress', function(event) {
        if (event.which === 13) {
            procesar();
            event.preventDefault();
        }
    });

    function procesar() {
        $('#modal_confirmacion').modal({
            keyboard: false
        })
    }

    function confirmar(){
        var url = "{{ route('users.update.password.mi.perfil') }}";
        $("#form").attr('action', url);
        $(".btn").hide();
        $(".btn-importar").hide();
        $(".spinner-btn").show();
        $("#form").submit();
    }

    document.getElementById('password-confirm').addEventListener('input', function() {
        document.getElementById('_email').value = this.value;
    });
</script>
@endsection
