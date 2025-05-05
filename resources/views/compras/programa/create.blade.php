@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR PROGRAMA</b>
            </div>
        </div>
    </div>
    @include('compras.programa.partials.form-create')
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
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var url = "{{ route('programa.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('programa.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection
