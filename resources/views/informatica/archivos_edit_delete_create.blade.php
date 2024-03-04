<!-- Crear Nuevo historial fotografico-->
<div class="modal fade" id="create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Fotografia</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                action="{{ route('sereges.registro_insertarFoto',$idregistro) }}">
                    @csrf


                    <div class="form-group">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Nombre:</label>


                        <input type="text" class="form-control" id="nombre" name="nombre" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>


                    <div class="form-group">
                        <label for="documento" style="color:black;font-weight: bold;"
                            class=" required col-md-6 col-form-label "><b style="color: black">Limite 10
                                mb.(solo.jpg):</b></label>

                        <div class="col-md-6">
                            <input type="file" required name="documento" id="documento">
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


<!-- Crear Nuevo registro de ingreso -->
<div class="modal fade" id="createIngreso">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento de Ingreso</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                action="{{ route('sereges.ingreso_insertarpdf',$idregistro) }}">
                    @csrf


                    <div class="form-group">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Nombre:</label>


                        <input type="text" class="form-control" id="nombre" name="nombre" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>


                    <div class="form-group">
                        <label for="documento" style="color:black;font-weight: bold;"
                            class=" required col-md-6 col-form-label "><b style="color: black">Limite 10
                                mb.(solo.pdf):</b></label>

                        <div class="col-md-6">
                            <input type="file" required name="documento" id="documento">
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
