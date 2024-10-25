@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MODIFICAR PARTIDA PRESUPUESTARIA</b>
            </div>
        </div>
    </div>
    @include('compras.partidas_prespuestarias.partials.form-editar')
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
            @if ($parent_presupuestaria != null)
                if($("#numeracion").val() == ""){
                    Modal("<b>[ERROR] . </b> La Numeracion es un dato obligatorio.");
                    return false;
                }
                if($("#numeracion").val().length != 5){
                    Modal("<b>[ERROR] . </b> La Numeracion tiene que tener obligatoriamente 5 caracteres.");
                    return false;
                }
            @endif
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
            document.getElementById('dependiente_id').disabled = false;
            document.getElementById('habilitar').disabled = false;
            var url = "{{ route('partida.presupuestaria.update') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('partida.presupuestaria.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
