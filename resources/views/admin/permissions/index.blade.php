@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>PERMISOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('admin.permissions.partials.search')
        @include('admin.permissions.partials.table')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready( function () {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
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
            var url = "{{ route('permissions.create') }}";
            window.location.href = url;
        }
    </script>
@endsection
