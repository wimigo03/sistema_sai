@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
    <div class="card card-custom">
        <div class="card-header font-verdana-15">
            <b>BENEFICIARIOS</b>
        </div>
        <div class="body body-table">
            <form action="{{ route('entregas.createEntrega') }}" method="get" id="form2">
                @csrf
                <input type="hidden" value="{{ $idpaquete }}" id="idcompra" name="idpaquete">

                <div class="form-group row font-roboto-12">
                    <div class="col-md-6">
                        <select name="beneficiario" id="beneficiario" class="form-control">
                            <option value="">-</option>
                            @foreach ($beneficiarios as $beneficiario)
                                <option value="{{ $beneficiario->id }}">
                                    {{ $beneficiario->ci }}--{{ $beneficiario->nombres }} {{ $beneficiario->ap }}
                                    {{ $beneficiario->am }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 text-right">
                        <span class="tts:right tts-slideIn tts-custom" aria-label="Agregar">
                            <span class="btn btn-info font-roboto-12" onclick="save2();">
                                <i class="fa-solid fa-plus fa-fw"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </form>
        </div>


    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            localStorage.clear();
            $('#beneficiario').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar un Beneficiario--",
                width: '100%'
            });




        });

        function save2() {
            if (validar_formulario() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form2").submit();
            }
        }

        function validar_formulario() {

            if ($("#beneficiario").val() == "") {
                message_alert("El campo <b>[Beneficiario]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function message_alert(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }
    </script>
@endsection
