<div class="modal fade" id="modalArchivo" tabindex="-1" aria-labelledby="modalArchivo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="body-border ">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        <div class="form-group row font-verdana-sm">
                            <input type="hidden" id="id">
                            <div class="col-12">
                                <div class="form-group">
                                    <label style="color:black;font-weight: bold;">CODIGO:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                        <input type="text" name="codigo" id="codigo" class="form-control"
                                            value="{{ old('codigo') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" onclick="buscarPorCodigo()"><i
                                                    class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>
                                    </div>
                                    <div id="error_codigo" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label style="color:black;font-weight: bold;">DESCRIPCION:</label>
                                    <textarea rows="1" class="form-control" id="descripcion" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label style="color:black;font-weight: bold;">ESTADO:</label>
                                    <input type="text" id="estado" class="form-control" readonly>
                                </div>
                            </div>
                            <input type="hidden" value="{{ old('activo_id') }}" id="activo_id">
                            <div class="btn-group ml-auto">
                                <button class="btn btn-primary btn-sm" id="btn_store_imagen" type="submit">
                                    <i class="fa-solid fa-paper-plane mr-2"></i>AGREGAR
                                </button>
                                <button class="btn btn-primary btn-sm" id="btn_update_imagen" type="submit">
                                    <i class="fa-solid fa-paper-plane mr-2"></i>ACTUALIZAR
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm mr-3"
                                data-dismiss="modal">CANCELAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
