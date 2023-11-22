<!-- Edit -->
<div class="modal fade" id="edit{{ $personeria->idpersoneria }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Editar Registro</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                    action="{{ route('personerias.update', $personeria->idpersoneria) }}">
                    @csrf


                    <div class="form-group">
                        <label for="resolucion" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Resol. Administrativa:</label>


                        <input type="text" class="form-control" id="resolucion" name="resolucion"
                            value="{{ $personeria->resoladmin }}" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>
                    <div class="form-group">
                        <label for="solicitante" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Solicitante:</label>


                        <input type="text" class="form-control" id="solicitante" name="solicitante"
                            value="{{ $personeria->solicitante }}" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>
                    <div class="form-group">
                        <label for="solicitante" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Tipo:</label>
                        <select name="tipo" id="tipo" required class="form-control form-control-sm select">
                            @if ($personeria->tipo == '1')
                                <option value="1" selected>NUEVA</option>
                            @else
                                <option value="1">NUEVA</option>
                            @endif

                            @if ($personeria->tipo == '2')
                                <option value="2" selected>ANTIGUA</option>
                            @else
                                <option value="2">ANTIGUA</option>
                            @endif


                        </select>
                    </div>

                    <div class="form-group">
                        <label for="documento" style="color:black;font-weight: bold;"
                            class=" required col-md-6 col-form-label "><b style="color: black">Limite 200
                                mb.(solo.pdf):</b></label>

                        <div class="col-md-6">
                            <input type="file" name="documento" id="documento">
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <a href="{{ url('/personerias/index') }}">
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


<!-- Delete -->
<div class="modal fade" id="delete{{ $personeria->idpersoneria }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">

                <h4 class="modal-title "><span class="employee_id">Eliminar Registro</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="GET"
                    action="{{ route('personerias.destroy', $personeria->idpersoneria) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <div class="text-center">
                        <h6>Esta Ud. seguro de eliminar el registro...?</h6>
                    </div>
            </div>
            <div class="modal-footer">
                <a href="{{ url('/personerias/index') }}">
                    <button type="button" class="btn btn-default btn-flat pull-left"><i class="fa fa-close"></i>
                        Cerrar</button>

                </a>
                <button type="submit" class="btn  btn-flat"><i class="fa fa-trash"></i> Elininar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Crear Nuevo -->
<div class="modal fade" id="create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Crear Registro</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                    action="{{ route('personerias.create') }}">
                    @csrf


                    <div class="form-group">
                        <label for="resolucion" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Resol. Administrativa:</label>


                        <input type="text" class="form-control" id="resolucion" name="resolucion" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>
                    <div class="form-group">
                        <label for="solicitante" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Solicitante:</label>


                        <input type="text" class="form-control" id="solicitante" name="solicitante" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>

                    <div class="form-group">
                        <label for="solicitante" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Tipo:</label>
                        <select name="tipo" id="tipo" required class="form-control form-control-sm select">
                            <option value="">-seleccione-</option>
                            <option value="1">NUEVA</option>
                            <option value="2">ANTIGUA</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="documento" style="color:black;font-weight: bold;"
                            class=" required col-md-6 col-form-label "><b style="color: black">Limite 200
                                mb.(solo.pdf):</b></label>

                        <div class="col-md-6">
                            <input type="file" required name="documento" id="documento">
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <a href="{{ url('/personerias/index') }}">
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


<!-- Actualizar Personeria -->
<div class="modal fade" id="edit2{{ $personeria->idpersoneria }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Actualizar Personeria Existente</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                    action="{{ route('personerias.create2', $personeria->idpersoneria) }}">
                    @csrf
                    <label for="solicitante" style="color:black;font-weight: bold;"
                        class="col-sm-10 control-label">Se va a actualizar la sgte. personalidad:</label>
                    <label for="solicitante" style="color:black;font-weight: bold;"
                        class="col-sm-10 control-label">Resolucion: {{ $personeria->resoladmin }}</label>
                    <label for="solicitante" style="color:black;font-weight: bold;"
                        class="col-sm-10 control-label">Solicitante: {{ $personeria->solicitante }}</label>
                    <hr>

                    <input type="hidden" name="resolucionAntigua" value="{{ $personeria->resoladmin }}">

                    <input type="hidden" name="solicitanteAntiguo" value="{{ $personeria->solicitante }}">


                    <div class="form-group">
                        <label for="resolucion" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Resol. Administrativa:</label>


                        <input type="text" class="form-control" id="resolucion" name="resolucion" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>
                    <div class="form-group">
                        <label for="solicitante" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Solicitante:</label>


                        <input type="text" class="form-control" id="solicitante" name="solicitante" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>
                    <div class="form-group">
                        <label for="solicitante" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Tipo:</label>
                        <select name="tipo" id="tipo" required class="form-control form-control-sm select">

                            <option value="3" selected>ACTUALIZADA</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="documento" style="color:black;font-weight: bold;"
                            class=" required col-md-6 col-form-label "><b style="color: black">Limite 200
                                mb.(solo.pdf):</b></label>

                        <div class="col-md-6">
                            <input type="file" required name="documento" id="documento">
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <a href="{{ url('/personerias/index') }}">
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
