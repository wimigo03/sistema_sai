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
                <form class="form-horizontal" method="POST" action="{{ route('sereges.registro_create') }}">
                    @csrf


                    <div class="form-group">
                        <div>

                            <div class="form-group row">

                                <div class="col-md-6">
                                    <label for="ncodigo" class="d-inline font-verdana-12">
                                        <b>N.Codigo:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="ncodigo" name="ncodigo" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="nurej" class="d-inline font-verdana-12">
                                        <b>Nurej:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="nurej" name="nurej" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="cud" class="d-inline font-verdana-12">
                                        <b>Cud:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="cud" name="cud" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombres" class="d-inline font-verdana-12">
                                        <b>Nombres:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="nombres" name="nombres" required
                                        onchange="javascript:this.value=this.value.toUpperCase();">
                                </div>

                                <div class="col-md-6">
                                    <label for="apellidos" class="d-inline font-verdana-12">
                                        <b>Apellidos:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="apellidos" name="apellidos" required
                                        onchange="javascript:this.value=this.value.toUpperCase();">
                                </div>

                                <div class="col-md-6">
                                    <label for="sexo" class="d-inline font-verdana-12">
                                        <b>Sexo</b>
                                    </label>

                                    <select name="sexo" id="sexo" placeholder="--Seleccionar--"
                                        class="form-control form-control-sm select" required>
                                        <option value="">-- Seleccione --</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="nacionalidad" class="d-inline font-verdana-12">
                                        <b>Nacionalidad:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="nacionalidad" name="nacionalidad" required
                                        onchange="javascript:this.value=this.value.toUpperCase();">
                                </div>

                                <div class="col-md-6">
                                    <label for="fnacimiento" class="d-inline font-verdana-12">
                                        <b>F.Nacimiento:</b>
                                    </label>

                                    <input type="date" placeholder="dd/mm/aaaa"
                                        class="form-control form-control-sm font-verdana-12" id="fnacimiento"
                                        name="fnacimiento" data-language="es" autocomplete="off" required>

                                </div>

                                <div class="col-md-6">
                                    <label for="fingreso" class="d-inline font-verdana-12">
                                        <b>F.Ingreso:</b>
                                    </label>

                                    <input type="date" placeholder="dd/mm/aaaa"
                                        class="form-control form-control-sm font-verdana-12" name="fingreso"
                                        id="fingreso" data-language="es" autocomplete="off" required>

                                </div>


                            </div>
                        </div>

                    </div>




                    <div class="modal-footer">
                        <a href="#" onclick="window.location.reload(true);">
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


<!-- Editar Registro -->
<div class="modal fade" id="edit{{ $serege->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Editar Registro</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sereges.registro_update', $serege->id) }}">
                    @csrf


                    <div class="form-group">
                        <div>

                            <div class="form-group row">

                                <div class="col-md-6">
                                    <label for="ncodigo" class="d-inline font-verdana-12">
                                        <b>N.Codigo:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="ncodigo" name="ncodigo" required value="{{ $serege->ncodigo }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="nurej" class="d-inline font-verdana-12">
                                        <b>Nurej:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="nurej" name="nurej" required value="{{ $serege->nurej }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="cud" class="d-inline font-verdana-12">
                                        <b>Cud:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="cud" name="cud" required value="{{ $serege->cud }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="nombres" class="d-inline font-verdana-12">
                                        <b>Nombres:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="nombres" name="nombres" required value="{{ $serege->nombres }}"
                                        onchange="javascript:this.value=this.value.toUpperCase();">
                                </div>

                                <div class="col-md-6">
                                    <label for="apellidos" class="d-inline font-verdana-12">
                                        <b>Apellidos:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="apellidos" name="apellidos" required value="{{ $serege->apellidos }}"
                                        onchange="javascript:this.value=this.value.toUpperCase();">
                                </div>

                                <div class="col-md-6">
                                    <label for="sexo" class="d-inline font-verdana-12">
                                        <b>Sexo</b>
                                    </label>

                                    <select name="sexo" id="sexo" placeholder="--Seleccionar--"
                                        class="form-control form-control-sm select" required>
                                        <option {{old('sexo',$serege->sexo)=="M"? 'selected':''}}  value="M">MASCULINO</option>
                                        <option {{old('sexo',$serege->sexo)=="F"? 'selected':''}}  value="F">FEMENINO</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="nacionalidad" class="d-inline font-verdana-12">
                                        <b>Nacionalidad:</b>
                                    </label>
                                    <input type="text" class="form-control form-control-sm font-verdana-12"
                                        id="nacionalidad" name="nacionalidad" required value="{{ $serege->nacionalidad }}"
                                        onchange="javascript:this.value=this.value.toUpperCase();">
                                </div>

                                <div class="col-md-6">
                                    <label for="fnacimiento" class="d-inline font-verdana-12">
                                        <b>F.Nacimiento:</b>
                                    </label>

                                    <input type="date" placeholder="dd/mm/aaaa"
                                        class="form-control form-control-sm font-verdana-12" id="fnacimiento"
                                        name="fnacimiento" data-language="es" autocomplete="off" required value="{{ $serege->fnacimiento }}">

                                </div>

                                <div class="col-md-6">
                                    <label for="fingreso" class="d-inline font-verdana-12">
                                        <b>F.Ingreso:</b>
                                    </label>

                                    <input type="date" placeholder="dd/mm/aaaa"
                                        class="form-control form-control-sm font-verdana-12" name="fingreso"
                                        id="fingreso" data-language="es" autocomplete="off" required value="{{ $serege->fingreso }}">

                                </div>


                            </div>
                        </div>

                    </div>




                    <div class="modal-footer">
                        <a href="#" onclick="window.location.reload(true);">
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
