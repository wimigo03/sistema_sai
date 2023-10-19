@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
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
            window.location.href = "{{ route('admin.users.create') }}";
        }
        function search(){
            var url = "{{ route('admin.users.search') }}";
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
            window.location.href = "{{ route('admin.users.index') }}";
        }
        function excel(){
            var url = "{{ route('admin.users.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }
    </script>
@endsection
