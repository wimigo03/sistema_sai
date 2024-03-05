<div class="modal fade" id="modalArchivo" tabindex="-1" aria-labelledby="modalArchivo" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Codigo de barras</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="body-border ">
                    <div class="encabezadoCodigoBarras mt-2">
                        <h5 class="mb-0">GAR. Gran Chaco</h5>
                        <h6 class="mb-0" id="codigoActivo"></h6>
                    </div>
                    <div id="codigoImagen" class="text-center">
                        <svg id="codigoDeBarras"></svg>
                        <div id="codigoBarra"></div>
                    </div>
                    <p class="descripcionStyle" id="description"></p>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="mb-4" style="font-size: 1.5rem;">Imprimir Etiquetas</h1>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cantidad" style="font-size: 0.875rem;">Cantidad:</label>
                                <input type="number" min="1" value="1" name="cantidad" id="cantidad" class="form-control" required>
                            </div>
                        </div>
                        <div class="btn-group ml-auto">
                            <a href="#" id="imprimirEtiquetas" class="btn btn-primary">Imprimir</a>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>