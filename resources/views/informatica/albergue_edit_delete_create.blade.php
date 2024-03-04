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
                <form class="form-horizontal" method="POST" action="{{ route('sereges.albergue_create') }}">
                    @csrf


                    <div class="form-group">
                        <label for="resolucion" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Nombre:</label>


                        <input type="text" class="form-control" id="nombre" name="nombre" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>

                    <div class="col-md-5 pl-1">
                        <label for="tipo" class="d-inline font-verdana-bg">
                            <b>Tipo:</b>
                        </label>

                        <select name="tipo" id="tipo" placeholder="--Seleccionar--"
                            class="form-control form-control-sm select" required>
                            <option value="">-- Seleccione --</option>
                            <option value="1">Albergue</option>
                            <option value="2">Hogar</option>
                        </select>
                    </div>


                    <div class="col-md-5 pl-1">
                        <label for="dea" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">DEA:</label>
                        <select name="dea" id="dea" class="form-control form-control-sm select2" required>
                            <option value="">--Seleccione--</option>
                            @foreach ($deas as $index => $value)
                                <option value="{{ $index }}" @if (old('dea') == $index) selected @endif>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>




                    <div class="modal-footer">
                        <a href="{{ url('/sereges/albergue_index') }}">
                            <button type="button" class="btn btn-default btn-flat pull-left"><i
                                    class="fa fa-close"></i>
                                Cerrar</button>
                        </a>
                        <button type="submit" class="btn  btn-flat" name="edit"><i class="fa fa-check-square"></i>
                            Guardar</button>



                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Edit -->
<div class="modal fade" id="edit{{ $albergues->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Editar Registro</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST"
                    action="{{ route('sereges.albergue_update', $albergues->id) }}">
                    @csrf


                    <div class="form-group">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Nombre:</label>


                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="{{ $albergues->nombre }}" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>


                    <div class="col-md-5 pl-1">
                        <label for="tipo" class="d-inline font-verdana-bg">
                            <b>Tipo:</b>
                        </label>

                        <select name="tipo" id="tipo" placeholder="--Seleccionar--"
                            class="form-control form-control-sm select" required>
                            <option {{old('tipo',$albergues->tipo)=="1"? 'selected':''}}  value="1">ALBERGUE</option>
                            <option {{old('tipo',$albergues->tipo)=="2"? 'selected':''}} value="2">HOGAR</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dea" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Dea:</label>
                        <select name="dea" id="dea" class="form-control form-control-sm select" required>

                            @foreach ($deas as $index => $value)
                                @if ($index == $albergues->dea->id)
                                    <option value="{{ $index }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $index }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>



                    <div class="modal-footer">
                        <a href="{{ url('/sereges/albergue_index') }}">
                            <button type="button" class="btn btn-default btn-flat pull-left"><i
                                    class="fa fa-close"></i>
                                Cerrar</button>
                        </a>
                        <button type="submit" class="btn  btn-flat" name="edit"><i class="fa fa-check-square"></i>
                            Guardar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
