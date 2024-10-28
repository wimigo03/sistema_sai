@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR REMITENTE</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form method="POST" action="{{ route('correspondencia.local.remitente.guardar') }}" id="form">
            @csrf
            <div class="form-group row font-roboto-12">
                <div class="col-md-4 pr-1 pl-1">
                    <label for="nombre" class="d-inline"><b>Nombre(s)</b></label>
                    <input type="text" name="nombres" id="nombres" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();" required>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-6 pr-1 pl-1">
                    <label for="apellido" class="d-inline"><b>Apellido(s)</b></label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();" required>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-3 pr-1 pl-1">
                    <label for="nro_carnet" class="d-inline"><b>Nro de documento</b></label>
                    <input type="text" name="ci" id="ci" class="form-control font-roboto-12" required>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-8 pr-1 pl-1">
                    <label for="unidad" class="d-inline"><b>Unidad / Area</b></label>
                    <select name="lugar" id="lugar" class="form-control font-roboto-12 select2">
                        <option value="">-</option>
                        @foreach ($unidades as $unidad)
                            <option value="{{ $unidad->id_unidad }}">{{ $unidad->nombre_unidad }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-6 pr-1 pl-1">
                    @can('correspondencia.local.lugar.crear')
                        <a href="{{ route('correspondencia.local.lugar.crear') }}">
                            <button class="btn btn-warning font-roboto-12" type="button">
                                <i class="fa fa-address-book fa-fw" aria-hidden="true"></i> Registrar unidad o area
                            </button>
                        </a>
                    @endcan
                </div>
                <div class="col-md-6 pr-1 pl-1 text-right">
                    <button class="btn btn-outline-primary font-roboto-12" type="button" id="insertar_item_material">
                        <i class="fa-solid fa-paper-plane fa-fw"></i> Guardar
                    </button>
                    <button class="btn btn-outline-danger font-roboto-12" type="button" id="cancelar">
                        <i class="fas fa-times fa-fw"></i> Cancelar
                    </button>
                    <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $("#insertar_item_material").click(function() {
            if (validar_detalle_material() == true) {
                $("#form").submit();
            }
        });

        $("#cancelar").click(function() {
            window.location.href = "{{ route('correspondencia.local.index') }}";
        });

        function validar_detalle_material() {
            if ($("#nombres").val() == "") {
                Modal('[EL CAMPO NOMBRES ES OBLIGATORIO]');
                return false;
            }
            if ($("#apellidos").val() == "") {
                Modal('[EL CAMPO APELLIDOS NO PUEDE ESTAR VACIO]');
                return false;
            }
            return true;
        };
    </script>
@endsection
