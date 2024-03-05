@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <b>FORMULARIO CREAR DISTRITO</b>
    </div>
    <div class="card-body">
        @include('canasta_v2.distrito.partials.create-form')
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
            var url = "{{ route('distritos.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('distritos.index') }}";
        }
    </script>
@endsection
