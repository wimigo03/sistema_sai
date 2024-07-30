@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MODIFICAR CRONOGRAMA DE ENTREGA</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.paquetes-barrio.partials.editar')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha_entrega', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_entrega").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
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

        function validar(){
            if($("#lugar_entrega").val() == ""){
                Modal("El campo <b>[LUGAR DE ENTREGA]</b> es un dato obligatorio...");
                return false;
            }

            if($("#fecha_entrega").val() == ""){
                Modal("El campo <b>[FECHA DE ENTREGA]</b> es un dato obligatorio...");
                return false;
            }

            if($("#hora_inicio").val() == ""){
                Modal("El campo <b>[HORA DE INICIO]</b> es un dato obligatorio...");
                return false;
            }

            if($("#hora_final").val() == ""){
                Modal("El campo <b>[HORA FINAL]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('paquetes.barrio.update') }}";
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
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.barrio.index', ':id') }}";
            url = url.replace(':id', paquete_id);
            window.location.href = url;
        }
    </script>
@endsection
