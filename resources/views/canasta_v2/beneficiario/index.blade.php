@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <b>BENEFICIARIOS</b>
    </div>
    <div class="card-body">
        @include('canasta_v2.beneficiario.partials.search')
        @include('canasta_v2.beneficiario.partials.table')
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tipo').select2({
                placeholder: "--Tipo--"
            });

            $('#dea').select2({
                placeholder: "--DEA--"
            });

            $('#idBarrio').select2({
                placeholder: "--Barrios--"
            });

            $('#estado').select2({
                placeholder: "--Estado--"
            });
            $('#ocupacion').select2({
                placeholder: "--Estado--"
            });
        });

        function procesar(){
            var url = "{{ route('beneficiarios.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('barrios.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('beneficiarios.index') }}";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('beneficiarios.create') }}";
        }
    </script>
@endsection
