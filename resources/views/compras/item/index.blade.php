@extends('layouts.admin')
@section('content')
<div class="row abs-center">
    <div class="col-md-10">
        <div class="card-body">
            <div class="form-group row font-roboto-20">
                <div class="col-md-12 text-center linea-completa">
                    <strong>MATERIALES</strong>
                </div>
            </div>
            @include('compras.item.partials.search')
            @include('compras.item.partials.table')
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#btn-item').removeClass("btn-outline-dark").addClass("btn-dark");
        $(document).ready(function() {
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });

            $('#unidad_id').select2({
                theme: "bootstrap4",
                placeholder: "--Unidad de Medida--",
                width: '100%'
            });

            $('#partida_presupuestaria_id').select2({
                theme: "bootstrap4",
                placeholder: "--Partida Presupuestaria--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            /*var cleave = new Cleave('#precio', {
                numeral: true,
                numeralDecimalScale: 2,
                numeralThousandsGroupStyle: 'thousand'
            });*/
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var url = "{{ route('item.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('item.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function get_unidades(){
            var url = "{{ route('unidad.medida.index') }}";
            window.location.href = url;
        }

        function limpiar(){
            var url = "{{ route('item.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
