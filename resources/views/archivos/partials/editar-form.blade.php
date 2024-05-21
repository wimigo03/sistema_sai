<form {{--method="post"--}} action="{{-- route('archivos2.insertar') --}}" enctype="multipart/form-data" id="form">
    @csrf
    <input type="hidden" name="archivo_id" value="{{ $archivos->idarchivo }}" id="archivo_id">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="agendado" class="d-inline"><b>Tipo de documento :</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <select name="tipodocumento" id="tipodocumento" class="form-control select2" required>
                <option value=""></option>
                @foreach ($tipos as $tipo)
                    @if ($archivos->idtipo == $tipo->idtipo)
                        <option value="{{ $tipo->idtipo }}" selected>{{ $tipo->nombretipo }}</option>
                    @else
                        <option value="{{ $tipo->idtipo }}">{{ $tipo->nombretipo }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="fecha_recepcion" class="d-inline"><b>Fecha Recepcion/Envio :</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha" value="{{ $date2 }}" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" id="fecha" data-language="es">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="numero" class="d-inline"><b>Nro. de documento :</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" id="nombredocumento" value="{{ $archivos->nombrearchivo }}" name="nombredocumento" class="form-control font-roboto-12" required>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="referencia" class="d-inline"><b>Referencia :</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <textarea type="text" name="referencia" class="form-control font-roboto-12" id="referencia" onchange="javascript:this.value=this.value.toUpperCase();" required>{{ $archivos->referencia }}</textarea>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-5 pr-1 pl-1 text-right">
            <label for="referencia" class="d-inline text-danger"><b>Peso limite de archivo 200 MB (Solo .pdf) :</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="file" name="documento" id="file" class="form-control font-roboto-12" required>
        </div>
    </div>
</form>
<div class="form-group row">
    <div class="col-md-5 pr-1 pl-1">
        <span class="btn btn-outline-primary font-roboto-12" id="atras">
            <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
    <div class="col-md-2 pr-1 pl-1 font-roboto-12" id="progressBar">
        <div></div>
    </div>
    <div class="col-md-5 pr-1 pl-1 text-right">
        <span class="btn btn-primary font-roboto-12" id="procesar">
            <i class="fas fa-paper-plane fa-fw"></i> Actualizar
        </span>
        <span class="btn btn-danger font-roboto-12" id="cancelar">
            <i class="fas fa-times fa-fw"></i> Cancelar
        </span>
        <br>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
