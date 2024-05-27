@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ROLES</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('admin.roles.partials.search')
        @include('admin.roles.partials.table')
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

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function create(){
            window.location.href = "{{ route('roles.create') }}";
        }
        function procesar(){
            var url = "{{ route('roles.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }
        function limpiar(){
            window.location.href = "{{ route('roles.index') }}";
        }
    </script>
@endsection
