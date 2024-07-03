@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>BENEFICIARIOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1">
                <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
                    <i class="fas fa-angle-double-left fa-fw"></i>&nbsp;Ir atras
                </span>
                <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
            </div>
        </div>
        <form action="{{ route('entregas.createEntrega') }}" method="get" id="form2">
            @csrf
            <input type="hidden" value="{{ $idpaquete }}" id="paquete_id" name="idpaquete">
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-6 pr-1 pl-1">
                    <select name="beneficiario" id="beneficiario" class="form-control">
                        <option value="">-</option>
                        @foreach ($beneficiarios as $beneficiario)
                            <option value="{{ $beneficiario->id }}">
                                {{ $beneficiario->ci }} - {{ $beneficiario->nombres }} {{ $beneficiario->ap }}
                                {{ $beneficiario->am }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row abs-center font-roboto-12">
                <div class="col-md-2 pr-1 pl-1 text-center">
                    <span class="btn btn-block btn-primary font-roboto-12" onclick="procesar();">
                        <i class="fa-solid fa-paper-plane fa-fw"></i>&nbsp;Registrar
                    </span>
                    <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                </div>
                <div class="col-md-2 pr-1 pl-1 text-center">
                    <span class="btn btn-block btn-danger font-roboto-12" onclick="cancelar();">
                        <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                    </span>
                    <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            localStorage.clear();
            $('#beneficiario').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function procesar() {
            if (validar_formulario() == true) {
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form2").submit();
            }
        }

        function cancelar(){
            var paquete_id = $("#paquete_id").val()
            var url = "{{ route('entregas.entrega_index',':paquete_id') }}";
            url = url.replace(':paquete_id',paquete_id);
            window.location.href = url;
        }

        function validar_formulario() {
            if ($("#beneficiario").val() == "") {
                Modal("El campo <b>[Beneficiario]</b> es un dato obligatorio.");
                return false;
            }
            return true;
        }
    </script>
@endsection
