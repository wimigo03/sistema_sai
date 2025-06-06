@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.configuracion') }}"> Configuracion</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('partida.presupuestaria.index') }}">Partidas Presupuestarias</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Registrar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-list-ul fa-fw"></i>&nbsp;<b class="title-size">REGISTRAR PARTIDA PRESUPUESTARIA</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.partidas_prespuestarias.partials.form-create')
        </div>
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
            /* if($("#descripcion").val() == ""){
                Modal("<b>[ERROR] . </b> La Descripcion es un dato obligatorio.");
                return false;
            } */
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
