<div class="form-group row font-roboto-13">
    <div class="col-md-12 pr-1 pl-1 text-center">
        <img src="{{ asset(substr($entrega->beneficiario->dir_foto, 2)) }}" alt="img-no-disponible" id="img-beneficiario">
    </div>
</div>
<div class="row font-roboto-13">
    <div class="col-md-6 pr-1 pl-1 text-right">
        <label for=""><b>BENEFICIARIO :</b></label>
    </div>
    <div class="col-md-6 pr-1 pl-1">
        {{ $entrega->beneficiario->nombres . ' ' . $entrega->beneficiario->ap . ' ' . $entrega->beneficiario->am }}
    </div>
</div>
<div class="row font-roboto-13">
    <div class="col-md-6 pr-1 pl-1 text-right">
        <label for=""><b>NRO. DE CARNET :</b></label>
    </div>
    <div class="col-md-6 pr-1 pl-1">
        {{ $entrega->beneficiario->ci . ' ' . $entrega->beneficiario->expedido }}
    </div>
</div>
<div class="row font-roboto-13">
    <div class="col-md-6 pr-1 pl-1 text-right">
        <label for=""><b>DISTRITO :</b></label>
    </div>
    <div class="col-md-6 pr-1 pl-1">
        {{ $entrega->distrito != null ? $entrega->distrito->nombre : '[Error]' }}
    </div>
</div>
<div class="row font-roboto-13">
    <div class="col-md-6 pr-1 pl-1 text-right">
        <label for=""><b>BARRIO :</b></label>
    </div>
    <div class="col-md-6 pr-1 pl-1">
        {{ $entrega->barrio->nombre }}
    </div>
</div>
<div class="row font-roboto-13">
    <div class="col-md-6 pr-1 pl-1 text-right">
        <label for=""><b>NRO. DE ENTREGA :</b></label>
    </div>
    <div class="col-md-6 pr-1 pl-1">
        {{ $entrega->paquete->numero }}
    </div>
</div>
<div class="row font-roboto-13">
    <div class="col-md-6 pr-1 pl-1 text-right">
        <label for=""><b>MES / GESTION :</b></label>
    </div>
    <div class="col-md-6 pr-1 pl-1">
        {{ $entrega->paquete_barrio != null ? $entrega->paquete_barrio->periodos : '[Error]' }}
        /
        {{ $entrega->paquete != null ? $entrega->paquete->gestion : '[Error]' }}
    </div>
</div>
<div class="row font-roboto-13">
    <div class="col-md-6 pr-1 pl-1 text-right">
        <label for=""><b>ESTADO :</b></label>
    </div>
    <div class="col-md-6 pr-1 pl-1">
        {{ $entrega->status }}
    </div>
</div>
