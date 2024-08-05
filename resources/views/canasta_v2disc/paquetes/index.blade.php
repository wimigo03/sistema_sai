@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>PAQUETES Disc.</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2disc.paquetes.partials.search')
        @include('canasta_v2disc.paquetes.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#periodo_id').select2({
                theme: "bootstrap4",
                placeholder: "--Periodo--",
                width: '100%'
            });

            $('#entrega').select2({
                theme: "bootstrap4",
                placeholder: "--N° entrega--",
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
            var url = "{{ route('paquetes.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            window.location.href = "{{ route('paquetes.index') }}";
        }

        function create(){
            window.location.href = "{{ route('paquetesdisc.create') }}";
        }
    </script>
@endsection
