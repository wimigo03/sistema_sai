<div class="modal fade" id="create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" ><b>CREAR NUEVO BARRIO</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="post"
                    action="{{ route('barrios.store') }}">
                    @csrf


                    <div class="form-group">
                        <label for="nombre" style="font-weight: bold;">Tipo</label>


                            <select name="tipo" id="tipo" class="form-control form-control-sm select2" required>
                                <option value="">-- Elija una opcion --</option>
                                @foreach ($tipos as $index => $value)
                                    <option value="{{ $index }}" @if(request('tipo') == $index) selected @endif >{{ $value }}</option>
                                @endforeach
                            </select>

                    </div>
                    <div class="form-group">
                        <label for="nombre" class="d-inline">Nombre</label>
                        <input type="text" name="nombre" required id="nombre" value="{{old('nombre')}}" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm font-verdana-bg intro {{ $errors->has('nombre') ? ' is-invalid' : '' }}">

                    </div>

                    <div class="form-group">
                        <label for="distrito" class="d-inline">Distrito</label>
                        <select name="distrito" id="distrito" class="form-control form-control-sm select2" required>
                            <option value="">-- Elija una opcion --</option>
                            @foreach ($distritos as $index => $value)
                                <option value="{{ $index }}" @if(request('distrito') == $index) selected @endif >{{ $value }}</option>
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
