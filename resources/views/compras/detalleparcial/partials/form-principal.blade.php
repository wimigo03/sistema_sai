<div class="form-group row">
    <div class="col-md-12">
        <label for="objeto" class="d-inline font-verdana-bg">
            <b>Informacion de la Compra</b>
        </label>
        <input type="hidden" name="objeto" value="{{$compras->objeto}}">
        <textarea cols="1" rows="2" class="form-control form-control-sm font-verdana-bg" id="objeto">{{$compras->objeto}}</textarea>
    </div>
    <div class="col-md-5">
        <label for="solicitante" class="d-inline font-verdana-bg">
            <b>Solicitante</b>&nbsp;
        </label>
        <input type="hidden" name="solicitante" value="{{$compras->nombrearea}}">
        <input type="text" value="{{$compras->nombrearea}}" class="form-control form-control-sm font-verdana-bg" id="solicitante">
    </div>
    <div class="col-md-3">
        <label for="modalidad" class="d-inline font-verdana-bg">
            <b>Modalidad</b>&nbsp;
        </label>
        <input type="hidden" name="modalidad" value="CONTRATACION MENOR">
        <input type="text" value="CONTRATACION MENOR" class="form-control form-control-sm font-verdana-bg" id="modalidad">
    </div>
    <div class="col-md-2">
        <label for="controlinterno" class="d-inline font-verdana-bg">
            <b>Precio Referencial</b>
        </label>
        <input type="hidden" name="subtotal" value="{{$subtotal}}">
        <input type="text" value="{{$subtotal}}" class="form-control form-control-sm font-verdana-bg" id="subtotal" onkeypress="return valideNumber(event);">
    </div>
    <div class="col-md-2">
        <label for="preventivo" class="d-inline font-verdana-bg">
            <b>Preventivo</b>
        </label>
        <input type="hidden" name="preventivo" value="{{$compras->preventivo}}">
        <input type="text" value="{{$compras->preventivo}}" class="form-control form-control-sm font-verdana-bg" id="preventivo">
    </div>
    <div class="col-md-4">
        <label for="proveedor" class="d-inline font-verdana-bg">
            <b>Proveedor</b>&nbsp;
        </label>
        <input type="hidden" name="proveedor" value="{{$compras->nombreproveedor}}">
        <input type="text" value="{{$compras->nombreproveedor}}" class="form-control form-control-sm font-verdana-bg" id="proveedor">
    </div>
    <div class="col-md-4">
        <label for="representante" class="d-inline font-verdana-bg">
            <b>Representante</b>&nbsp;
        </label>
        <input type="hidden" name="representante" value="{{$compras->representante}}">
        <input type="text" value="{{$compras->representante}}" class="form-control form-control-sm font-verdana-bg" id="representante">
    </div>
    <div class="col-md-2">
        <label for="cedula" class="d-inline font-verdana-bg">
            <b>Nro. CI</b>
        </label>
        <input type="hidden" name="cedula" value="{{$compras->cedula}}">
        <input type="text" value="{{$compras->cedula}}" class="form-control form-control-sm font-verdana-bg" id="cedula">
    </div>
    <div class="col-md-2">
        <label for="nit" class="d-inline font-verdana-bg">
            <b>Nit/CI</b>
        </label>
        <input type="hidden" name="nit" value="{{$compras->nitci}}">
        <input type="text" value="{{$compras->nitci}}" class="form-control form-control-sm font-verdana-bg" id="nit">
    </div>
    <div class="col-md-5">
        <label for="actividad" class="d-inline font-verdana-bg">
            <b>Actividad</b>
        </label>
        <input type="hidden" name="actitividad" value="{{$compras->nombreprograma}}">
        <input type="text" value="{{$compras->nombreprograma}}" class="form-control form-control-sm font-verdana-bg" id="actitividad">
    </div>
    <div class="col-md-2">
        <label for="nit" class="d-inline font-verdana-bg">
            <b>Telefono</b>
        </label>
        <input type="hidden" name="telefono" value="{{$compras->telefonoproveedor}}">
        <input type="text" value="{{$compras->telefonoproveedor}}" class="form-control form-control-sm font-verdana-bg" id="telefono">
    </div>
    <div class="col-md-2">
        <label for="cedula" class="d-inline font-verdana-bg">
            <b>Cedula</b>
        </label>
        <input type="hidden" name="cedulaaceptacion" value="{{$compras->cedula}}">
        <input type="text" value="{{$compras->cedula}}" class="form-control form-control-sm font-verdana-bg" id="cedulaaceptacion">
    </div>
</div>
<div class="form-group row">
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
            <b>Fecha</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
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
</div>
<div class="form-group row">
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
</div>