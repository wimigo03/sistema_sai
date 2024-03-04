@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <b>FORMULARIO REGISTRAR BARRIO</b>
    </div>
    <div class="card-body">
        @include('canasta_v2.barrio.partials.editar-form')
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var url = "{{ route('barrios.update') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('barrios.index') }}";
        }
    </script>
@endsection
