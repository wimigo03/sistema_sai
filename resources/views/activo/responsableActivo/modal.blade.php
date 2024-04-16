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

                    <div class="btn-group ml-auto">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
