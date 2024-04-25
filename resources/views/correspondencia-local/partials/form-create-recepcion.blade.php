<form method="POST" action="{{ route('correspondencia.local.guardar') }}" id="form" enctype="multipart/form-data">
    @csrf
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 pr-1 pl-1">
            <label for="fecha" class="d-inline"><b>Fecha de recepcion</b></label>
            <input type="text" name="fecha" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" id="fecha" data-language="es" autocomplete="off" value="{{ $fechaActual }}">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-10 pr-1 pl-1">
            <label for="emp" class="d-inline"><b>Remitente</b></label>
            <input type="text" name="emp" id="emp" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-10 pr-1 pl-1">
            <label for="asunto" class="d-inline"><b>Asunto</b></label>
            <textarea type="text" name="asunto" class="form-control font-roboto-12" required id="asunto" oninput="this.value = this.value.toUpperCase();"></textarea>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 pr-1 pl-1">
            <label for="codigo" class="d-inline"><b>Codigo</b></label>
            <input type="text" name="codigo" class="form-control font-roboto-12" id="codigo" value="{{ $maxId2 }}" required>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="hoja_ruta" class="d-inline"><b>Hoja de ruta</b></label>
            <input type="text" name="oficio" class="form-control font-roboto-12" value="{{ $hojaderuta }}" required>
        </div>
        <div class="col-md-8 pr-1 pl-1">
            <label for="tipo_correspondencia" class="d-inline"><b>Tipo correspondencia</b></label>
            <select name="tipo" id="tipo" class="form-control select2">
                @foreach ($tipos as $tipo)
                    <option value="">-</option>
                    <option value="{{ $tipo->idtipo_corresp }}">
                        {{ $tipo->nombre_tipo }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-6 pr-1 pl-1">
            <label for="documento" class="d-inline text-danger"><b>Limite Max. 20MB (.pdf)</b></label>
            <input type="file" name="documento" id="file" class="form-control font-roboto-12" required>
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-6 pr-1 pl-1">
            <button class="btn btn-primary font-roboto-12" type="button" onclick="cancelar();">
                <i class="fas fa-arrow-left fa-fw"></i> Ir atras
            </button>
            @can('correspondencia_local.tipo.crear')
                <a href="{{ route('correspondencia.local.tipo.crear') }}" class="btn btn-warning font-roboto-12">
                    <i class="fa fa-align-justify fa-fw" aria-hidden="true"></i> Registrar tipo de correspondencia
                </a>
            @endcan
            @can('correspondencia_local.remitente.crear')
                <a href="{{ route('correspondencia.local.remitente.crear') }}" class="btn btn-primary font-roboto-12">
                    <i class="fa fa-user fa-fw" aria-hidden="true"></i> Registrar remintente
                </a>
            @endcan
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="uploadFile();" id="insertar_item_material">
                <i class="fas fa-paper-plane fa-fw"></i> Guardar
            </button>
            <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                <i class="fas fa-times fa-fw"></i> Cancelar
            </button>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            <progress id="progressBar" value="0" max="100" style="width:300px;display:none"></progress>
            <p id="loaded_n_total"></p>
        </div>
    </div>
    <br>
    {{--<div align='center'>
        <a href="{{ route('correspondencia.local.tipo.crear') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar tipo">
            <button class="btn btn-sm btn-warning font-verdana" type="button">
                &nbsp;<i class="fa fa-lg fa-align-justify" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="{{ route('correspondencia.local.remitente.crear') }}" class="tts:left tts-slideIn tts-custom"
            aria-label="Agregar Remitente">
            <button class="btn btn-sm btn-primary font-verdana" type="button">
                &nbsp;<i class="fa fa-lg fa-user" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" id="cancelar" value="Cancelar">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="Guardar" onclick="uploadFile()" id="insertar_item_material">
        </br></br>
        <progress id="progressBar" value="0" max="100" style="width:300px;display:none"></progress>
        <p id="loaded_n_total"></p>
    </div>--}}
</form>
