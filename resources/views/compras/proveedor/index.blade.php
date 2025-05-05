@extends('layouts.dashboard')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>PROVEEDORES</strong>
            </div>
        </div>
        @include('compras.proveedor.partials.search')
        @include('compras.proveedor.partials.table')
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

            var cleave = new Cleave('#nro', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
            });

            var cleave = new Cleave('#nro_ci', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
            });

            var cleave = new Cleave('#nit', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
            });

            var cleave = new Cleave('#telefono', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
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
            var url = "{{ route('proveedor.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('proveedor.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('proveedor.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
