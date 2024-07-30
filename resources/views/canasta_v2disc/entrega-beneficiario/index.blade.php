@extends('layouts.admin')
<style>
    #img-beneficiario {
        width: 200px;
        height: auto;
        border-radius: 10%;
        overflow: hidden;
    }
</style>
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>BUSCAR ENTREGA DE BENEFICIARIO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.entrega-beneficiario.partials.search')
        @isset($entrega)
            @include('canasta_v2.entrega-beneficiario.partials.show')
        @endisset
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var cleave = new Cleave('#codigo', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function search() {
            if(!validar()){
                return false;
            }
            var url = "{{ route('entrega.beneficiario.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function validar() {
            if($("#codigo").val() == ""){
                Modal("[Parametro de busqueda no encontrado]");
                return false;
            }
            return true;
        }

        /*function limpiar() {
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.index', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            window.location.href = url;
        }*/
    </script>
@endsection
