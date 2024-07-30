@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>REGISTRAR PARTIDA PRESUPUESTARIA</strong>
            </div>
        </div>
        @include('compras.partidas_prespuestarias.partials.form-create')
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

            var cleave = new Cleave('#numeracion', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
            });
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar() {
            if($("#categoria_programatica_id >option:selected").val() == ""){
                Modal("<b>[ERROR] . </b> La Categoria Programatica es un dato obligatorio.");
                return false;
            }
            if($("#numeracion").val() == ""){
                Modal("<b>[ERROR] . </b> La Numeracion es un dato obligatorio.");
                return false;
            }
            if($("#numeracion").val().length != 5){
                Modal("<b>[ERROR] . </b> La Numeracion tiene que tener obligatoriamente 5 caracteres.");
                return false;
            }
            if($("#nombre").val() == ""){
                Modal("<b>[ERROR] . </b> El nombre de la Partida Presupuestaria es un dato obligatorio.");
                return false;
            }
            if($("#descripcion").val() == ""){
                Modal("<b>[ERROR] . </b> La Descripcion es un dato obligatorio.");
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('partida.presupuestaria.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('partida.presupuestaria.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
