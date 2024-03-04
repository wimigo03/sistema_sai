@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            <b>LISTADO DE ACTIVOS</b>
        </div>
        <div class="card-body">
            @include('activo.gestionactivo.partials.search')
            @include('activo.gestionactivo.partials.table')
        </div>
    </div>

    @include('activo.gestionactivo._codigoBarras')
@section('scripts')
    <script src="/js/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
        function create() {
            $(".btn").hide();
            $(".btn-importar").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('activo.gestionactivo.create') }}";
        }

        function search() {
            var url = "{{ route('activo.gestionactivo.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".btn-importar").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function limpiar() {
            $(".btn").hide();
            $(".btn-importar").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('activo.gestionactivo.index') }}";
        }
        $(function() {
            var codigoBarraActual = null;
            $('.ver-codigo').on('click', function(e) {
                e.preventDefault();
                codigoBarraActual = $(this).data('codigo');
                $('#codigoActivo').html(codigoBarraActual);
                $('#description').html($(this).data('descripcion'));

                var svg = document.getElementById('codigoDeBarras');
                svg.setAttribute('width', '80%');
                JsBarcode(svg, codigoBarraActual, {
                    format: 'CODE128',
                    displayValue: false,
                    width: 3,
                    height: 100,
                    font: 'verdana',
                    textAlign: 'center',
                    fontOptions: "italic"
                });
                $('#modalArchivo').modal('show');
            });
            $('#imprimirEtiquetas').click(function() {
                var cantidad = $('#cantidad').val();

                if (cantidad > 0) {
                    var url = `/Activo/etiquetas/${codigoBarraActual}/imprimir/${cantidad}`;
                    window.open(url, '_blank');
                } else {
                    alert('La cantidad debe ser mayor a cero.');
                }
            });
        });
    </script>
@endsection
@endsection
