@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-bgt">
        <b>ROLES</b>
    </div>
    <div class="card-body">
        @include('admin.roles.partials.search')
        @include('admin.roles.partials.table')
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready( function () {
            $('#dea_id').select2({
                placeholder: "--Unidad Administrativa--"
            });
            $('#estado').select2({
                placeholder: "--Estado--"
            });
        });

        function create(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('roles.create') }}";
        }
        function procesar(){
            var url = "{{ route('roles.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }
        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('roles.index') }}";
        }
    </script>
@endsection
