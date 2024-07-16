<form action="#" method="post" id="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="control_interno_id" id="control_interno_id" value="{{ $control_interno->id }}">
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="tipo_id" class="d-inline"><b>Tipo:</b></label>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="text" value="{{ $control_interno->tipo->nombretipo }}" class="form-control font-roboto-12 intro" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="codigo" class="d-inline"><b>Codigo:</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" value="{{ $control_interno->codigo }}" class="form-control font-roboto-12 intro" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="numero" class="d-inline"><b>Numero:</b></label>
        </div>
        <div class="col-md-1 pr-1 pl-1">
            <input type="text" name="numero" id="numero" value="{{ $control_interno->nro }}" class="form-control font-roboto-12 intro" disabled>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="destinatario" class="d-inline"><b>Dirigido a:</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <select name="destinatario_id" id="destinatario_id" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($destinatarios as $destinatario)
                    <option value="{{ $destinatario->id }}"
                        @if($destinatario->id == old('destinatario_id') || (isset($control_interno) && $control_interno->empleado_destinatario_id == $destinatario->id))
                            selected
                        @endif>
                        {{ $destinatario->empleado }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="referencia" class="d-inline"><b>Referencia:</b></label>
        </div>
        <div class="col-md-6 pr-1 pl-1">
            <input type="text" name="referencia" id="referencia" value="{{ $control_interno->referencia }}" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="fecha" class="d-inline"><b>Fecha:</b></label>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha" id="fecha" value="{{ \Carbon\Carbon::parse($control_interno->fecha)->format('d/m/Y') }}" class="form-control font-roboto-12 intro" data-language="es">
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="observaciones" class="d-inline"><b>Observaciones:</b></label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <textarea name="observaciones" id="observaciones" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">{{ $control_interno->observaciones }}</textarea>
        </div>
    </div>
    <div class="form-group row font-roboto-12 align-items-center">
        <div class="col-md-4 pr-1 pl-1 text-right">
            <label for="word" class="d-inline">
                <b>Subir archivo editable <i class="fa fa-file-word fa-fw text-primary"></i>(.docx .doc):</b>
            </label>
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="file" class="form-control font-roboto-12" id="word_file" name="word_file" accept=".docx,.doc">
        </div>
    </div>
    @if ($control_interno == null)
        <div class="form-group row font-roboto-12 align-items-center">
            <div class="col-md-4 pr-1 pl-1 text-right">
                <label for="pdf" class="d-inline">
                    <b>Subir archivo de respaldo <i class="fa fa-file-pdf fa-fw text-danger"></i>(.pdf .jpg .jpeg):</b></label>
            </div>
            <div class="col-md-5 pr-1 pl-1">
                <input type="file" class="form-control font-roboto-12" id="pdf_file" name="pdf_file" accept=".pdf,.jpg,.jpeg">
            </div>
        </div>
    @endif
    <div class="form-group row">
        <div class="col-md-12 text-center">
            @if ($control_interno->estado == '1')
                <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                    <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
                </span>
                <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                    <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                </span>
                <span class="btn btn-outline-warning font-roboto-12 float-right" onclick="anular();">
                    <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Anular
                </span>
            @else
                <span class="btn btn-outline-success font-roboto-12 float-right" onclick="habilitar();">
                    <i class="fa-solid fa-check fa-fw"></i>&nbsp;Habilitar
                </span>
            @endif
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>
