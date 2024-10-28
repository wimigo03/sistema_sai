<input type="hidden" name="dea_id" value="{{ $dea_id }}">
<input type="hidden" name="empleado_id" value="{{ $empleado->idemp }}" id="empleado_id">
<div class="form-group row font-roboto-12 abs-center">
    <div class="col-md-12 pr-1 pl-1">
        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
            <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
        </span>
        @can('empleados.show')
            <span class="btn btn-danger font-roboto-12 float-right" onclick="exportar();">
                <i class="fas fa-file-pdf fa-fw"></i> Kardex
            </span>
        @endcan
    </div>
</div>
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
                @include('empleados.partials.datos-personales-show')
            </div>
            <div class="tab-pane fade" id="content2" role="tabpanel" aria-labelledby="tab2">
                @include('empleados.partials.datos-laborales-show')
            </div>
        </div>
    </div>
</div>
