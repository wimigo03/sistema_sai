@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-1 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
            <a href="{{url()->previous()}}" class="color-icon-1">
                <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
            </a>
        </span>
    </div>
    <div class="col-md-11 text-right titulo">
        <b>GESTIONAR PERSONAL-P/{{strtoupper($area_actual->nombrearea)}}/REGISTRAR</b>

        <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
            <button class="btn btn-sm btn-danger font-verdana" type="button">
                &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
    </div>
    <div class="col-md-12">
        <hr>
        @if(Session::has('pendiente'))
        <div class="alert alert-danger font-verdana-bg">
            {{ Session::get('pendiente') }}
        </div>
        <hr>

        @endif

        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        <hr>

        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger font-verdana-bg">
            {{ Session::get('error') }}
        </div>
        <hr>

        @endif
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>
</div>
<div class="body-borderd">
    <form method="POST" action="{{ route('planta.guardar') }}">
        @csrf
        @include('rechumanos.planta.partials.form-create')
    </form>
</div>
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#procedencia').select2({
                placeholder: "--Seleccionar--"
            });

        $('#idfile').select2({
            placeholder: "--Seleccionar File de Personal--"
        });
        // Suponiendo que estás escuchando el envío del formulario para validar el campo de selección
        $('form').submit(function(event) {
            var idfile = $('#idfile').val();
            if (!idfile) {
                $('#idfile-error').text('Este campo es obligatorio.'); // Muestra el mensaje de error si no se ha seleccionado ninguna opción
                event.preventDefault(); // Evita que el formulario se envíe si hay errores
            }
        });


        $("#exppoai").hide();
    });

    function checkPoai() {
        if ($('#poai').prop('checked')) {
            $("#exppoai").show();
        } else {
            $("#exppoai").hide();
        }
    }
</script>
@endsection
@endsection