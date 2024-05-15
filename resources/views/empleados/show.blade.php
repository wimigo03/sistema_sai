@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>INFORMACION DE PERSONAL</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('empleados.partials.show-form')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function exportar(){
            var id = $("#empleado_id").val();
            var url = "{{ route('empleado.pdf.show', ':id') }}";
            url = url.replace(':id', id);
            window.open(url, '_blank');
        }

        function recontratar(){
            var id = $("#empleado_id").val();
            var url = "{{ route('empleado.recontratar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function retirar(){
            var id = $("#empleado_id").val();
            var url = "{{ route('empleado.retirar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function cancelar(){
            var url = "{{ route('empleado.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
