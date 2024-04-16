<div class="modal fade" id="create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>NUEVO BARRIO</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="post" action="{{ route('barrios.store') }}">
                    @csrf


                    <div class="form-group">
                        <label for="nombre" style="font-weight: bold;">Tipo:</label>


                        <select name="tipo" id="tipo" class="form-control form-control-sm select2" required>
                            <option value="">-- Elija una opcion --</option>
                            @foreach ($tipos as $index => $value)
                                <option value="{{ $index }}" @if (request('tipo') == $index) selected @endif>
                                    {{ $value }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="nombre" class="d-inline">Nombre</label>
                        <input type="text" name="nombre" required id="nombre" value="{{old('nombre')}}" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm font-verdana-12 intro {{ $errors->has('nombre') ? ' is-invalid' : '' }}">

                    </div>

                    <div class="form-group">
                        <label for="distrito" style="font-weight: bold;">Distrito:</label>
                        <select name="distrito" id="distrito" class="form-control form-control-sm select2" required>
                            <option value="">-- Elija una opcion --</option>
                            @foreach ($distritos as $index => $value)
                                <option value="{{ $index }}" @if (request('distrito') == $index) selected @endif>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>


            </div>
            <div class="modal-footer">
                <a href="{{ url('/barrios') }}">
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




<!-- Edit barrio -->
<div class="modal fade" id="edit{{ $datos->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Editar Registro</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('barrios.update') }}">
                    @csrf
                    <input type="text"  id="barrio_id" name="barrio_id"  value="{{ $datos->id }}" >
                    <div class="form-group">
                        <label for="solicitante" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Tipo:</label>
                        <select name="tipo" id="tipo" required class="form-control form-control-sm select">
                            @if ($datos->tipo == '1')
                                <option value="1" selected>BARRIO</option>
                            @else
                                <option value="1">BARRIO</option>
                            @endif

                            @if ($datos->tipo == '2')
                                <option value="2" selected>COMUNIDAD</option>
                            @else
                                <option value="2">COMUNIDAD</option>
                            @endif

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Nombre:</label>


                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="{{ $datos->nombre }}" required
                            onchange="javascript:this.value=this.value.toUpperCase();">

                    </div>


                    <div class="form-group">
                        <label for="distrito" style="color:black;font-weight: bold;"
                            class="col-sm-6 control-label">Distrito:</label>
                        <select name="distrito" id="distrito" required class="form-control form-control-sm select">
                            @foreach ($distritos2 as $distrito2)
                                @if ($datos->distrito_id == $distrito2->id)
                                    <option value="{{ $distrito2->id }}" selected>{{ $distrito2->nombre }}</option>
                                @else
                                <option value="{{ $distrito2->id }}" >{{ $distrito2->nombre }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <a href="{{ url('/barrios') }}">
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
