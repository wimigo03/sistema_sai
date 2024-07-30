@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row abs-center font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>PROGRAMAS</strong>
            </div>
        </div>
        @include('compras.programa.partials.search')
        @include('compras.programa.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha_registro', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_registro").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var url = "{{ route('programa.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('programa.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('programa.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
