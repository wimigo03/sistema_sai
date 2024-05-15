@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MODIFICAR REGISTRO ITEM</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('files.partials.editar-form')
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

            var cleave = new Cleave('#nro_file', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#haber_basico', {
                numeral: true,
                numeralDecimalScale: 2,
                numeralThousandsGroupStyle: 'thousand',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#nivel_administrativo', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#clase', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#nivel_salarial', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
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
            if($("#area_id >option:selected").val() == ""){
                Modal("El campo de seleccion <b>[Area]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#nro_file").val() == "") {
                Modal('El campo <b>[Nro. de File]</b> es un dato obligaorio.');
                return false;
            }
            if ($("#cargo").val() == "") {
                Modal('El campo <b>[Cargo]</b> es un dato obligatorio.');
                return false;
            }
            if ($("#cargo_detalle").val() == "") {
                Modal('El campo <b>[Nombre del Cargo]</b> es un dato obligatorio.');
                return false;
            }
            if($("#categoria >option:selected").val() == ""){
                Modal("El campo de seleccion <b>[Categoria]</b> es un dato obligatorio...");
                return false;
            }
            if($("#tipo >option:selected").val() == ""){
                Modal("El campo de seleccion <b>[Tipo]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('file.update') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('file.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
