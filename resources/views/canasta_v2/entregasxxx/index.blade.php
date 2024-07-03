@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>PAQUETES</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.entregas.partials.search')
        @include('canasta_v2.entregas.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            $('#dea').select2({
                theme: "bootstrap4",
                placeholder: "--DEA--",
                width: '100%'
            });

            $('#distrito').select2({
                theme: "bootstrap4",
                placeholder: "--Distrito--",
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
                procesar();
                event.preventDefault();
            }
        });

        function procesar(){
            var url = "{{ route('entregas.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            window.location.href = "{{ route('entregas.index') }}";
        }

        function create(){
            window.location.href = "{{ route('entregas.create_paquete') }}";
        }
    </script>
@endsection
