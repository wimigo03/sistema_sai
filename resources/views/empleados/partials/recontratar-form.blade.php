<form action="#" method="post" id="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="dea_id" value="{{ $dea_id }}">
    <input type="hidden" name="empleado_id" value="{{ $empleado->idemp }}">
    <div class="form-group row font-roboto-13">
        <div class="col-md-12 pr-1 pl-1">
            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1" role="tab" aria-controls="content1" aria-selected="true">
                        Datos Personales
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab2" data-toggle="tab" href="#content2" role="tab" aria-controls="content2" aria-selected="false">
                        Datos Laborales
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="myTabsContent">
                <div class="tab-pane fade show active" id="content1" role="tabpanel" aria-labelledby="tab1">
                    @include('empleados.partials.datos-personales-recontratar')
                </div>
                <div class="tab-pane fade" id="content2" role="tabpanel" aria-labelledby="tab2">
                    @include('empleados.partials.datos-laborales-recontratar')
                </div>
            </div>
        </div>
    </div>
</form>
<div class="form-group row">
    <div class="col-md-6 pr-1 pl-1">
        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
            <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
    <div class="col-md-6 pr-1 pl-1 text-right">
        <span class="btn btn-primary font-roboto-12" onclick="procesar();">
            <i class="fas fa-paper-plane fa-fw"></i> Actualizar
        </span>
        <span class="btn btn-danger font-roboto-12" onclick="cancelar();">
            <i class="fas fa-times fa-fw"></i> Cancelar
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
