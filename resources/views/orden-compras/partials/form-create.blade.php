<div class="form-group row font-verdana-bg">
    <div class="col-md-12">
        <label for="objeto" class="d-inline label-show">Informacion de la compra</label>
        <textarea cols="1" rows="1" name="objeto" class="form-control form-control-sm font-verdana-bg" id="objeto" disabled>{{ $solicitud->objeto }}</textarea>
    </div>
</div>
<div class="form-group row font-verdana-bg">
    <div class="col-md-5 pr-1">
        <label for="solicitante" class="d-inline label-show">Solicitante</label>
        <input type="text" value="{{ $solicitud->area->nombrearea }}" class="form-control form-control-sm font-verdana-bg" id="solicitante" disabled>
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <label for="modalidad" class="d-inline label-show">Modalidad</label>
        <select id="modalidad" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
            <option value="1">CONTRATACION MENOR</option>
        </select>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="precio_referencial" class="d-inline label-show">Precio Ref. (Bs.)</label>
        <input type="hidden" name="subtotal" value="{{ $subtotal }}" id="subtotal">
        <input type="text" value="{{ number_format($subtotal,2,'.',',') }}" class="form-control form-control-sm font-verdana-bg" disabled>
    </div>
    <div class="col-md-2 pl-1">
        <label for="preventivo" class="d-inline label-show">Preventivo</label>
        <input type="text" name="preventivo" value="{{ $solicitud->preventivo }}" class="form-control form-control-sm font-verdana-bg" id="preventivo" disabled>
    </div>
</div>
<div class="form-group row font-verdana-bg">
    <div class="col-md-5 pr-1">
        <label for="proveedor" class="d-inline label-show">Proveedor</label>
        <select id="proveedor" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
            <option value="">-</option>
            @foreach ($proveedores as $index => $value)
                <option value="{{ $index }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-5 pr-1 pl-1">
        <label for="representante" class="d-inline label-show">Representante</label>
        <input type="text" value="" class="form-control form-control-sm font-verdana-bg" id="representante" disabled>
    </div>
    <div class="col-md-2 pl-1">
        <label for="cedula" class="d-inline label-show">Nro. Carnet</label>
        <input type="text" value="" class="form-control form-control-sm font-verdana-bg" id="nro_carnet" disabled>
    </div>
</div>
<div class="form-group row font-verdana-bg">
    <div class="col-md-6 pr-1">
        <label for="actividad" class="d-inline label-show">Actividad</label>
        <input type="text" value="{{ $solicitud->programa->nombreprograma }}" class="form-control form-control-sm font-verdana-bg" id="actitividad" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="nit" class="d-inline label-show">NIT</label>
        <input type="text" value="" class="form-control form-control-sm font-verdana-bg" id="nit" disabled>
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <label for="telefono" class="d-inline label-show">Telefono</label>
        <input type="text" value="" class="form-control form-control-sm font-verdana-bg" id="telefono" disabled>
    </div>
</div>
{{--<div class="form-group row">
    <div class="col-md-3">
        <label for="informe" class="d-inline font-verdana-bg">
            <b>Informe de Cotizacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="informe" value="{{request('informe')}}" placeholder="--Nro.--" class="form-control form-control-sm font-verdana-bg" id="informe">
    </div>
    <div class="col-md-3">
        <label for="nro_orden" class="d-inline font-verdana-bg">
            <b>Orden de Compra</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="orden" value="{{request('orden')}}" placeholder="--Nro.--" class="form-control form-control-sm font-verdana-bg" id="orden" onkeypress="return valideNumberSinDecimal(event);">
    </div>
    <div class="col-md-3">
        <label for="fecha" class="d-inline font-verdana-bg">
            <b>Fecha Orden</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="fechaOden" value="{{request('fechaOden')}}" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-bg" id="fecha" data-language="es" autocomplete="off">
    </div>
    <div class="col-md-3">
        <label for="apertura" class="d-inline font-verdana-bg">
            <b>Apertura Programatica</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="apertura" value="{{request('apertura')}}" class="form-control form-control-sm font-verdana-bg" id="apertura">
    </div>
    <div class="col-md-3">
        <label for="partida" class="d-inline font-verdana-bg">
            <b>Partida de Gasto</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="partida" value="{{request('partida')}}" class="form-control form-control-sm font-verdana-bg" id="partida">
    </div>
    <div class="col-md-3">
        <label for="hoja_ruta" class="d-inline font-verdana-bg">
            <b>Hoja de Ruta</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="ruta" value="{{request('ruta')}}" class="form-control form-control-sm font-verdana-bg" id="ruta" onkeypress="return valideNumberSinDecimal(event);">
    </div>
    <div class="col-md-3">
        <label for="codigo_interno" class="d-inline font-verdana-bg">
            <b>Codigo Interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="cinterno" value="{{request('cinterno')}}" class="form-control form-control-sm font-verdana-bg" id="cinterno" onkeypress="return valideNumberSinDecimal(event);">
    </div>
    <div class="col-md-3">
        <label for="entrega" class="d-inline font-verdana-bg">
            <b>Plazo de Entrega</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="entrega" value="{{request('entrega')}}" placeholder="--dias--" class="form-control form-control-sm font-verdana-bg" id="entrega" onkeypress="return valideNumberSinDecimal(event);">
    </div>
    <div class="col-md-3">
        <label for="fecha_inicio" class="d-inline font-verdana-bg">
            <b>Fecha de Inicio</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="fechainicio" value="" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-bg" id="fechainicio" data-language="es" autocomplete="off">
    </div>
    <div class="col-md-3">
        <label for="fecha_conclusion" class="d-inline font-verdana-bg">
            <b>Fecha de Conclusion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="fechaconclusion" value="" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-bg" id="fechaconclusion" data-language="es" autocomplete="off">
    </div>
    <div class="col-md-3">
        <label for="fecha_invitacion" class="d-inline font-verdana-bg">
            <b>Fecha Invitacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="fechainvitacion" value="" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-bg" id="fechainvitacion" data-language="es" autocomplete="off">
    </div>
    <div class="col-md-3">
        <label for="fecha_aceptacion" class="d-inline font-verdana-bg">
            <b>Fecha Aceptacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="fechaaceptacion" value="" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-bg" id="fechaaceptacion" data-language="es" autocomplete="off">
    </div>
    <div class="col-md-4">
        <label for="codigo_cite" class="d-inline font-verdana-bg">
            <b>Codigo Cite</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="codigocite" value="{{request('codigocite')}}" class="form-control form-control-sm font-verdana-bg" id="codigocite">
    </div>
    <div class="col-md-2">
        <label for="hora_presentacion" class="d-inline font-verdana-bg">
            <b>Hora</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="time" name="horapresentacion" value="{{request('horapresentacion')}}" class="form-control form-control-sm font-verdana-bg text-center" id="horapresentacion">
    </div>
    <div class="col-md-3">
        <label for="nota_adjudicacion" class="d-inline font-verdana-bg">
            <b>Nota de Adjudicacion</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="notaadjudicacion" value="{{request('notaadjudicacion')}}" class="form-control form-control-sm font-verdana-bg" id="notaadjudicacion">
    </div>
    <div class="col-md-3">
        <label for="fecha_inicio_solicitud" class="d-inline font-verdana-bg">
            <b>F. Inicio Solicitud</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="fechainiciosoli" value="" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-bg" id="fechainiciosoli" data-language="es" autocomplete="off">
    </div>
    <div class="col-md-3">
        <label for="control_interno" class="d-inline font-verdana-bg">
            <b>Control Interno</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="controlinterno" value="{{request('controlinterno')}}" class="form-control form-control-sm font-verdana-bg" id="controlinterno">
    </div>
    <div class="col-md-3">
        <label for="aut_solicitante" class="d-inline font-verdana-bg">
            <b>Aut. Solicitante</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="solicitante" value="{{request('solicitante')}}" class="form-control form-control-sm font-verdana-bg" id="solicitante">
    </div>

    <div class="col-md-3">
        <label for="memorandum_1" class="d-inline font-verdana-bg">
            <b>memorandum 1</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="memorandum1" value="{{request('memorandum1')}}" class="form-control form-control-sm font-verdana-bg" id="memorandum1">
    </div>
    <div class="col-md-3">
        <label for="memorandum_2" class="d-inline font-verdana-bg">
            <b>memorandum 2</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="memorandum2" value="{{request('memorandum2')}}" class="form-control form-control-sm font-verdana-bg" id="memorandum2">
    </div>
    <div class="col-md-3">
        <label for="comision_1" class="d-inline font-verdana-bg">
            <b>Comisión 1</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="comision1" value="{{request('comision1')}}" class="form-control form-control-sm font-verdana-bg" id="comision1">
    </div>
    <div class="col-md-3">
        <label for="comision_2" class="d-inline font-verdana-bg">
            <b>Comisión 2</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="comision2" value="{{request('comision2')}}" class="form-control form-control-sm font-verdana-bg" id="comision2">
    </div>
    <div class="col-md-3">
        <label for="informe_1" class="d-inline font-verdana-bg">
            <b>Informe 1</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="informe1" value="{{request('informe1')}}" class="form-control form-control-sm font-verdana-bg" id="informe1">
    </div>
    <div class="col-md-3">
        <label for="informe_2" class="d-inline font-verdana-bg">
            <b>Informe 2</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
        </label>
        <input type="text" name="informe2" value="{{request('informe2')}}" class="form-control form-control-sm font-verdana-bg" id="informe2">
    </div>
</div>--}}
{{--<div class="form-group row">
    <div class="col-md-12 text-right">
        <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="create();">
            <i class="fa-solid fa-paper-plane"></i>
            &nbsp;Crear Orden de Compra
        </button>
        <button class="btn btn-danger font-verdana-bg" type="button" >

            <a href="{{url()->previous()}}" style="color:white">Cancelar</a>
        </button>
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

    </div>
</div>--}}
