@extends('layouts.admin')
@section('content')
    <div class="row font-verdana-bg">
    <div class="col-md-3 titulo">
    <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{url()->previous()}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
        </div>
        <div class="col-md-9 text-center titulo">
            <b>GESTIONAR PERSONAL-P/{{strtoupper($area_actual->nombrearea)}}/REGISTRAR</b>
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#procedencia').select2({
                placeholder: "--Seleccionar--"
            });

            $('#idfile').select2({
                placeholder: "--Seleccionar--"
            });

            $("#exppoai").hide();
        });

        function checkPoai(){
            if( $('#poai').prop('checked') ) {
                $("#exppoai").show();
            }else{
                $("#exppoai").hide();
            }
        }
    </script>
@endsection