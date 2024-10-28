@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MODIFICAR BARRIO DE ENTREGA CANASTA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>
                    {{ $entrega->paquete->numero }} ENTREGA
                    /
                    {{ $entrega->paquete_barrio->periodos }} ({{ $entrega->paquete->gestion }})
                    /
                    {{ $entrega->distrito->nombre }}
                    -
                    {{ $entrega->barrio->nombre }}
                </b>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>
                    <u>
                        {{ $entrega->beneficiario->nombres . ' ' . $entrega->beneficiario->ap . ' ' . $entrega->beneficiario->am }}
                    </u>
                </b>
            </div>
        </div>
        @include('canasta_v2disc.entregas.partials.editar')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#barrio_id').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar barrio--",
                width: '100%'
            });
        });

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar() {
            if ($("#barrio_id >option:selected").val() == "") {
                Modal('[Para continuar debe seleccionar un barrio]');
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('entregasdisc.update') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function cancelar(){
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregasdisc.index', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            window.location.href = url;
        }
    </script>
@endsection
