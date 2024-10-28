@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR UNIDAD / AREA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form method="post" action="{{ route('correspondencia.local.lugar.guardar') }}" id="form">
            @csrf
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-4 pr-1 pl-1">
                    <label for="area_unidada" class="d-inline"><b>Area / Unidad</b></label>
                    <input type="text" name="nombre" class="form-control font-roboto-12" id="unidad" oninput="this.value = this.value.toUpperCase();" required>
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-4 pr-1 pl-1 text-center">
                    <button class="btn btn-outline-primary font-roboto-12" type="button" id="insertar_item_material">
                        <i class="fa-solid fa-paper-plane fa-fw"></i> Guardar
                    </button>
                    <button class="btn btn-outline-danger font-roboto-12" type="button" id="cancelar">
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

        $("#cancelar").click(function() {
            window.location.href = "{{ route('correspondencia.local.index') }}";
        });

        function validar_detalle_material() {
            if ($("#unidad").val() == "") {
                Modal('[EL CAMPO UNIDAD-COMUNIDAD ES OBLIGATORIO]');
                return false;
            }
            return true;
        };
    </script>
@endsection
