@extends('layouts.admin')
@section('content')
<div class="card-body">
    <div class="form-group row font-roboto-20">
        <div class="col-md-12 text-center linea-completa">
            <strong>REGISTRAR ALMACEN</strong>
        </div>
    </div>
    @include('almacenes.almacen.partials.form-create')
</div>
@section('scripts')
    <script type="text/javascript">
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

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar(){
            if($("#nombre").val() == ""){
                Modal("<center>[ERROR AL VALIDAR NOMBRE DEL ALMACEN]</center>");
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('almacen.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('almacen.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
