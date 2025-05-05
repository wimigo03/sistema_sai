@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>USUARIOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('admin.users.partials.search')
        @include('admin.users.partials.table')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready( function () {
            $('#role').select2({
                theme: "bootstrap4",
                placeholder: "--Role--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var url = "{{ route('users.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('users.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('users.index') }}";
            window.location.href = url;
        }

        function excel(){
            var url = "{{ route('users.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }
    </script>
@endsection
