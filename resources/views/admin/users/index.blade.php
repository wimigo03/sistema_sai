@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-bgt">
        <b>USUARIOS</b>
    </div>
    <div class="card-body">
        @include('admin.users.partials.search')
        @include('admin.users.partials.table')
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready( function () {
            $('#estado').select2({
                placeholder: "--Estado--"
            });
        });

        function create(){
            $(".btn").hide();
            $(".btn-importar").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('users.create') }}";
        }
        function procesar(){
            var url = "{{ route('users.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".btn-importar").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }
        function limpiar(){
            $(".btn").hide();
            $(".btn-importar").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('users.index') }}";
        }
        function excel(){
            var url = "{{ route('users.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }
    </script>
@endsection
