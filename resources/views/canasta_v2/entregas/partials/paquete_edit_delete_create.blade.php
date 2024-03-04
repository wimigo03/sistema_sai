<div class="modal fade" id="create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>CREAR NUEVO PAQUETE</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST"
                action="{{ route('entregas.create') }}">
                    @csrf
                    <div class="form-group">
                        <div>

                            <div class="col-md-6">
                                <label for="gestion" class="d-inline font-verdana-12">
                                    <b>Gestion:</b>
                                </label>
                                <select name="gestion" id="gestion" placeholder="--Seleccionar--"
                                    class="form-control form-control-sm select" required>
                                    <option value="">-- Seleccione --</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>



                            <div class="col-md-12">
                                <label for="items" class="d-inline font-verdana-12">
                                    <b>Items:</b>
                                </label>
                                <textarea type="text" rows="10" class="form-control form-control-sm font-verdana-12" id="items" name="items" required></textarea>
                            </div>

                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <a href="#" onclick="window.location.reload(true);">
                    <button type="button" class="btn btn-default btn-flat pull-left"><i class="fa fa-close"></i>
                        Cerrar</button>
                </a>
                <button type="submit" class="btn  btn-flat" name="edit"><i class="fa fa-check-square"></i>
                    Guardar</button>

                </form>

            </div>
        </div>
    </div>
</div>
