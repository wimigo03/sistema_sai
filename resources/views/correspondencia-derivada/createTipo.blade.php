@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR TIPO DE CORRESPONDENCIA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form method="post" action="{{ route('correspondencia.local.tipo.guardar') }}" id="form">
            @csrf
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-4 pr-1 pl-1">
                    <label for="tipo" class="d-inline"><b>Tipo</b></label>
                    <input type="text" name="nombre" id="tipo" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center text-center">
                <div class="col-md-6 pr-1 pl-1">
                    <button class="btn btn-outline-primary font-roboto-12" type="button" id="insertar_item_material">
                        <i class="fa-solid fa-paper-plane fa-fw"></i> Guardar
                    </button>
                    <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                        <i class="fas fa-times fa-fw"></i> Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $("#insertar_item_material").click(function() {
            if (validar_detalle_material() == true) {
                $("#form").submit();
            }
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function cancelar(){
            var url = "{{ route('correspondencia.local.crear') }}";
            window.location.href = url;
        }

        function validar_detalle_material() {
            if ($("#tipo").val() == "") {
                Modal('[EL CAMPO TIPO ES OBLIGATORIO]');
                return false;
            }
            return true;
        };
    </script>
@endsection
