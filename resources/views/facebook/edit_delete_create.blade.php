<!-- Crear Nuevo -->
<div class="modal fade" id="create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Crear Publicacion</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="GET"  action="{{ route('facebook.create') }}">
                    @csrf


                    <div class="form-group">
                        <label for="fecha" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Fecha:</label>

                        <input type="date" placeholder="dd/mm/aaaa"
                            class="form-control form-control-sm font-verdana-bg" id="fecha" name="fecha"
                            data-language="es" autocomplete="off" required>

                    </div>
                    <div class="form-group">
                        <label for="publicacion" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Publicacion:</label>


                        <input type="text" class="form-control" id="publicacion" name="publicacion" required>

                    </div>





            </div>
            <div class="modal-footer">
                <a href="{{ url('facebook') }}">
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
