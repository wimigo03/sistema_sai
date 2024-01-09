<div class="card card-body bg-light">
    <div class="form-group row font-verdana-bg">
        <div class="col-md-6 pr-1">
            <label for="idarea" class="d-inline label-show">Area:</label><br>
            <span class="font-verdana-bg">{{ $compra->area->nombrearea }}</span>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="controlinterno" class="d-inline label-show">Control Interno:</label><br>
            <span class="font-verdana-bg">{{ $compra->controlinterno }}</span>
        </div>
        <div class="col-md-3 pl-1">
            <label for="tipo" class="d-inline label-show">Tipo:</label><br>
            <span class="font-verdana-bg">{{ $compra->tipo_compra }}</span>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-6 pr-1">
            <label for="idprograma" class="d-inline label-show">Programa:</label><br>
            <span class="font-verdana-bg">{{ $compra->programa->nombreprograma }}</span>
        </div>
        <div class="col-md-6 pl-1">
            <label for="idcatprogramatica" class="d-inline label-show">Categoria Programatica:</label><br>
            <span class="font-verdana-bg">{{ $compra->cat_prog->nombrecatprogramatica }}</span>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-6 pr-1">
            <label for="preventivo" class="d-inline label-show">Preventivo</label><br>
            <span class="font-verdana-bg">{{ $compra->preventivo }}</span>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="f_preventivo" class="d-inline label-show">Fecha Preventivo</label><br>
            <span class="font-verdana-bg">{{ \Carbon\Carbon::parse($compra->fecha_preventivo)->format('d/m/Y') }}</span>
        </div>
        <div class="col-md-3 pl-1">
            <label for="estado" class="d-inline label-show">Estado</label><br>
            <span class="font-verdana-bg {{ $compra->color_estado }}">{{ $compra->estado }}</span>
        </div>
    </div>
    <div class="form-group row font-verdana-bg">
        <div class="col-md-6 pr-1">
            <label for="objeto" class="d-inline label-show">Objeto</label><br>
            <span class="font-verdana-bg">{{ $compra->objeto }}</span>
        </div>
        <div class="col-md-6 pl-1">
            <label for="justificacion" class="d-inline label-show">Justificacion</label><br>
            <span class="font-verdana-bg">{{ $compra->justificacion }}</span>
        </div>
    </div>
</div>