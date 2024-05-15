@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ITEMS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('files.partials.search')
        @include('files.partials.table')
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Area--",
                width: '100%'
            });

            $('#cargo').select2({
                theme: "bootstrap4",
                placeholder: "--Cargo--",
                width: '100%'
            });

            $('#categoria').select2({
                theme: "bootstrap4",
                placeholder: "--Categoria--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            var cleave = new Cleave('#nro_file', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#haber_basico', {
                numeral: true,
                numeralDecimalScale: 2,
                numeralThousandsGroupStyle: 'thousand',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#n_adm', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#clase', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#n_salarial', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var dea_id = $("#dea_id").val()
            var url = "{{ route('file.create',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('file.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('file.excel') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('file.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
