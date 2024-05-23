<br>
<div class="form-group row">
    <div class="col-md-6 pr-1">
        <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
            <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
        </span>
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
    <div class="col-md-6 pl-1 text-right">
        @if ($empleado->estado == '1')
            @can('empleados.retirar')
                <span class="btn btn-warning font-roboto-12" onclick="retirar();">
                    <i class="fas fa-user-times fa-fw"></i> Retirar
                </span>
            @endcan
        @else
            @can('empleados.recontratar')
                <span class="btn btn-primary font-roboto-12" onclick="recontratar();">
                    <i class="fas fa-address-card fa-fw"></i> Recontratar
                </span>
            @endcan
        @endif
        @can('empleados.show')
            <span class="btn btn-danger font-roboto-12" onclick="exportar();">
                <i class="fas fa-file-pdf fa-fw"></i> Exportar
            </span>
        @endcan
        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
<div class="card card-body">
    <div class="form-group row font-roboto-12 abs-center">
        <div class="col-md-12 pr-1 pl-1 text-center">
            <span class="{{ $empleado->color_status }}">
                <i class="fas fa-user fa-fw"></i> {{ $empleado->status_completo }}
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center">
            <img src="{{ asset($empleado->url_foto) }}" alt="logo" style="width-min: 100px; width: 250px; height: auto; border-radius: 10%;">
        </div>

        <div class="col-md-9">
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="apellido_paterno" class="d-inline"><b>Apellido Paterno:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    {{ $empleado->ap_pat }}
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="grado_academico" class="d-inline"><b>Grado academico:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    {{ $empleado->gradacademico }}
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="apellido_materno" class="d-inline"><b>Apellido Materno:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    {{ $empleado->ap_mat }}
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="rae" class="d-inline"><b>RAE:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    {{ $empleado->rae }}
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="nombre" class="d-inline"><b>Nombre Completo:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    {{ $empleado->nombres }}
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="registro_profesional" class="d-inline"><b>Registro Profesional:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    {{ $empleado->regprofesional }}
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="nro_carnet" class="d-inline"><b>Nro. Carnet:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    {{ $empleado->ci . ' ' . $empleado->extension }}
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="cuenta_banco" class="d-inline"><b>Cuenta Banco Union:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    {{ $empleado->cuentabanco }}
                </div>
            </div>
            <div class="form-group row font-roboto-13 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="natalicio" class="d-inline"><b>Natalicio:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    {{ $empleado->natalicio != null ? \Carbon\Carbon::parse($empleado->natalicio)->format('d/m/Y') : '' }}
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="file_contrato" class="d-inline"><b>N° File:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    {{ $empleado->filecontrato }}
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="libreta_militar" class="d-inline"><b>N° Libreta Militar:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    {{ $empleado->servmilitar }}
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="nit" class="d-inline"><b>NIT:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    {{ $empleado->nit }}
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="idioma" class="d-inline"><b>Idioma Principal:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    {{ $empleado->idioma }}
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="kua" class="d-inline"><b>KUA:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    {{ $empleado->kua }}
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="anhos_servicio" class="d-inline"><b>Años de servicio:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    {{ $empleado->aservicios }}
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="sigep" class="d-inline"><b>Sigep:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    <input type="checkbox" {{ $empleado->sigep == '1' ? 'checked' : '' }}>
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="inamovilidad" class="d-inline"><b>Inamovilidad:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    <input type="checkbox" {{ $empleado->inamovilidad == '1' ? 'checked' : '' }}>
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="cvitae" class="d-inline"><b>Curriculum Vitae:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    <input type="checkbox" {{ $empleado->cvitae == '1' ? 'checked' : '' }}>
                </div>
            </div>
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 text-right">
                    <label for="telefono" class="d-inline"><b>Celular:</b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    {{ $empleado->telefono }}
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <label for="sexo" class="d-inline"><b>Sexo:</b></label>
                </div>
                <div class="col-md-3 pl-1">
                    {{ $empleado->sexos }}
                </div>
            </div>
        </div>
    </div>
</div>
