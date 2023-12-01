@extends('layouts.admin')

@section('content')
    <style>
        .encabezadoCodigoBarras {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid #000;
            padding: 5px;
        }

        .descripcionStyle {
            color: #000 !important;
            font-size: 16px;
            font-weight: 400;
            border: 2px solid #000;
            padding: 5px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-4">
                <h1 class="mb-4" style="font-size: 1.5rem;">Generar Códigos de Barras</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-group">
                    <label for="codigo" style="font-size: 0.875rem;">Código:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" required>
                </div>
                <button id="generarCodigo" class="btn btn-primary">Generar Código</button>
                <div id="encontrado" style="display: none">
                    <div class="encabezadoCodigoBarras mt-2">
                        <h5 class="mb-0">GAR. Gran Chaco</h5>
                        <h6 class="mb-0" id="codigoActivo"></h6>
                    </div>
                    <div id="codigoImagen" class="text-center">
                        <svg id="codigoDeBarras"></svg>
                    </div>
                    <p class="descripcionStyle" id="codigoDescripcion"></p>
                </div>
                <div id="noEncontrado" style="display: none"></div>
                <hr>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 offset-md-4">
                <h1 class="mb-4" style="font-size: 1.5rem;">Imprimir Etiquetas</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-group">
                    <label for="cantidad" style="font-size: 0.875rem;">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" required>
                </div>
                <a href="#"" id="imprimirEtiquetas" class="btn btn-primary">Imprimir Etiquetas</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#generarCodigo').click(function() {
                var codigo = $('#codigo').val();
                $.ajax({
                    url: '/Activo/codigo-barras/' + codigo + '/buscar',
                    type: 'GET',
                    data: {
                        codigo: codigo
                    },
                    success: function(data) {
                        if (data) {
                            $('#codigoActivo').html(data.codigo);
                            $('#codigoDescripcion').html(data.descrip);
                            var svg = document.getElementById('codigoDeBarras');
                            svg.setAttribute('width', '100%');
                            JsBarcode(svg, data.codigo, {
                                format: 'CODE128',
                                displayValue: false,
                                width: 4,
                                height: 100,
                                font: 'verdana',
                                textAlign: 'center',
                                fontOptions: "italic"
                            });
                            $('#encontrado').show();
                            $('#noEncontrado').hide();
                        } else {
                            $('#encontrado').hide();
                            $('#noEncontrado').html(
                                'No se encontró ningún activo con ese código.');
                            $('#noEncontrado').show();
                        }
                    },

                    error: function(xhr, status, error) {
                        $('#encontrado').hide();
                        $('#noEncontrado').html('No se encontró ningun activo con ese código.');
                        $('#noEncontrado').show();
                    }
                });
            });

            $('#imprimirEtiquetas').click(function() {
                var codigo = $('#codigo').val();
                var cantidad = $('#cantidad').val();

                if (cantidad > 0) {
                    var url = `/Activo/etiquetas/${codigo}/imprimir/${cantidad}`;
                    window.open(url, '_blank');
                } else {
                    alert('La cantidad debe ser mayor a cero.');
                }
            });
        });
    </script>
@endsection
