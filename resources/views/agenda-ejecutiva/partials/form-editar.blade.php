<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="evento_id" value="{{ $evento->id }}">
    <input type="hidden" name="fecha2" value="{{ $evento->fecha }}">
    <input type="hidden" name="usuario" value="{{ $evento->usuario }}">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="agendado" class="d-inline"><b>Agendado por</b></label>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" name="usuario2" value="{{ $evento->usuario }}" class="form-control font-roboto-11 intro" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="fecha" class="d-inline"><b>Fecha</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1 text-right">
            <input type="date" name="fecha" value="{{ $evento->fecha }}" class="form-control font-roboto-11 intro">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="hora" class="d-inline"><b>Hora</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1 text-right">
            <input type="time" name="hora" value="{{ $evento->horaini }}" id="hora" class="form-control font-roboto-11 intro">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="evento" class="d-inline"><b>Evento</b></label>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <textarea type="text" name="titulo" id="titulo" onchange="javascript:this.value=this.value.toUpperCase();" class="form-control font-roboto-11 intro">{{ $evento->titulo }}</textarea>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="descripcion" class="d-inline"><b>Descripcion</b></label>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <textarea type="text" name="descripcion" id="descripcion" onchange="javascript:this.value=this.value.toUpperCase();" class="form-control font-roboto-11 intro">{{ $evento->descripcion }}</textarea>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="lugar" class="d-inline"><b>Lugar</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1 text-right">
            <input type="text" name="lugar" value="{{ $evento->lugar }}" id="lugar" class="form-control font-roboto-11 intro" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="coordinar" class="d-inline"><b>Coordinar con</b></label>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <input type="text" name="coordinar" value="{{ $evento->coordinar }}" id="coordinar" class="form-control font-roboto-11 intro" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="representante" class="d-inline"><b>Representante G.A.R.G.CH</b></label>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <input type="text" name="representante" value="{{ $evento->representante }}" id="representante" class="form-control font-roboto-11 intro" onchange="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>
</form>
<div class="form-group row">
    <div class="col-md-6 pr-1 pl-1">
        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
            <i class="fas fa-angle-double-left fa-fw"></i>&nbsp;Ir atras
        </span>
        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
    <div class="col-md-6 pr-1 pl-1 text-right">
        <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
            <i class="fa-solid fa-paper-plane fa-fw"></i>&nbsp;Actualizar
        </span>
        <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
            <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
        </span>
        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
