@extends('layouts.admin')
@section('content')
    @include('layouts.message_alert')
    <br>
    <div class="row font-verdana-bg">
        <div class="col-md-4 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('/expochaco/index') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
        </div>
        <div class="col-md-8 text-right titulo">
            <b>EDITAR SOLICITUD </b>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="body-border" style="background-color: #FFFFFF;">

        <form method="post" action="{{ route('expochaco.update') }}" id="form">
            @csrf
            <input type="hidden" name="pabellon" id="pabellon" value="GRAN CHACO">

            <input type="hidden" name="superficie" id="superficie" value="3x3">

            <input type="hidden" name="precio" id="precio" value="250">
            <input type="hidden" name="ci2" id="ci2">
            <input type="hidden" name="idsolicitud" id="idsolicitud" value="{{$solicitud->idsolicitud}}">

            <div class="body-border" style="background-color: #FFFFFF;">

                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="pabellon2" class="d-inline font-verdana-bg">
                            <b>PABELLON</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="pabellon2" disabled class="form-control form-control-sm font-verdana-bg"
                            id="pabellon2" value="GRAN CHACO">
                    </div>

                    <div class="col-md-4">
                        <label for="superficie2" class="d-inline font-verdana-bg">
                            <b>SUPERFICIE</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="superficie2" disabled class="form-control form-control-sm font-verdana-bg"
                            id="superficie2" value="3x3">
                    </div>

                    <div class="col-md-2">
                        <label for="superficie" class="d-inline font-verdana-bg">
                            <b>PRECIO EN Bs.</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="precio2" disabled class="form-control form-control-sm font-verdana-bg"
                            id="precio2" value="250">
                    </div>

                    <div class="col-md-4">
                        <label for="nstand" class="d-inline font-verdana-bg">
                            <b>N° DE STAND</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="nstand"  class="form-control form-control-sm font-verdana-bg"
                            id="nstand" value="{{$solicitud->nstand}}">
                    </div>

                    <div class="col-md-4">
                        <label for="nombrerecibo" class="d-inline font-verdana-bg">
                            <b>RECIBO A NOMBRE DE</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="nombrerecibo"  class="form-control form-control-sm font-verdana-bg"
                            id="nombrerecibo" value="{{$solicitud->recibonombre}}" onchange="javascript:this.value=this.value.toUpperCase();">
                    </div>

                    <div class="col-md-4">
                        <label for="cirecibo" class="d-inline font-verdana-bg">
                            <b>CI RECIBO</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="cirecibo"  class="form-control form-control-sm font-verdana-bg"
                            id="cirecibo" value="{{$solicitud->reciboci}}">
                    </div>

                </div>
            </div>
            <label for="representante" class="d-inline font-verdana-bg">
                <b>DATOS DEL SOLICITANTE</b>&nbsp;<span style="font-size:10px; color: red;"></span>
            </label>
            <div class="body-border" style="background-color: #FFFFFF;">

                <div class="form-group row">


                    <div class="col-md-4">
                        <label for="nombresolicitud" class="d-inline font-verdana-bg">
                            <b>NOMBRES Y APELLIDOS DEL SOLICITANTE</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <textarea name="nombresolicitud" cols="1" rows="2" class="form-control form-control-sm font-verdana-bg"
                            id="nombresolicitud" onchange="javascript:this.value=this.value.toUpperCase();">{{$solicitud->nombresolicitud}}</textarea>
                    </div>

                    <div class="col-md-2">
                        <label for="ci" class="d-inline font-verdana-bg">
                            <b>N° C.I.</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="ci" class="form-control form-control-sm font-verdana-bg" id="ci"
                            onchange="myFunction()" value="{{$solicitud->ci}}">
                    </div>



                    <div class="col-md-4">
                        <label for="asociacionsol" class="d-inline font-verdana-bg">
                            <b>ASOCIACION/FEDERACION</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <select name="asociacionsol" id="asociacionsol" placeholder="--Seleccionar--"
                                                    class="form-control form-control-sm select">
                            @if ($solicitud->asociacionsol== "FEREMYPE")
                            <option value="FEREMYPE" selected>FEREMYPE</option>
                            @else
                            <option value="FEREMYPE">FEREMYPE</option>
                            @endif

                            @if ($solicitud->asociacionsol == "CAPPIA")
                            <option value="CAPPIA" selected>CAPPIA</option>
                            @else
                            <option value="CAPPIA" >CAPPIA</option>
                            @endif

                            @if ($solicitud->asociacionsol == "COORDINADORA FERIAS")
                            <option value="COORDINADORA FERIAS" selected>COORDINADORA FERIAS</option>
                            @else
                            <option value="COORDINADORA FERIAS" >COORDINADORA FERIAS</option>
                            @endif

                            @if ($solicitud->asociacionsol == "APICULTORES")
                            <option value="APICULTORES" selected>APICULTORES</option>
                            @else
                            <option value="APICULTORES" >APICULTORES</option>
                            @endif

                            @if ($solicitud->asociacionsol == "ARTESANOS")
                            <option value="ARTESANOS" selected>ARTESANOS</option>
                            @else
                            <option value="ARTESANOS" >ARTESANOS</option>
                            @endif

                            @if ($solicitud->asociacionsol == "ASOVIT")
                            <option value="ASOVIT" selected>ASOVIT</option>
                            @else
                            <option value="ASOVIT" >ASOVIT</option>

                            @endif

                            @if ($solicitud->asociacionsol == "OTROS")
                            <option value="OTROS" selected>OTROS(Especifique el campo siguiente..)</option>
                            @else
                            <option value="OTROS" >OTROS(Especifique el campo siguiente..)</option>

                            @endif

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="cirepresentante" class="d-inline font-verdana-bg">
                            <b>OTROS ASOCIACION/ FEDERACION(En caso que selecciono otros en el campo anterior)</b>&nbsp;<span
                                style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="otros" class="form-control form-control-sm font-verdana-bg" id="otros"
                            onchange="javascript:this.value=this.value.toUpperCase();" value="{{$solicitud->asociacionotros}}">
                    </div>



                    <div class="col-md-6">
                        <label for="direccionsol" class="d-inline font-verdana-bg">
                            <b>DIRECCION DEL TALLER/NEGOCIO O EMPRENDIMIENTO</b>&nbsp;<span
                                style="font-size:10px; color: red;">*</span>
                        </label>
                        <textarea name="direccionsol" cols="1" rows="3" class="form-control form-control-sm font-verdana-bg"
                            id="direccionsol" onchange="javascript:this.value=this.value.toUpperCase();">{{$solicitud->direccionsol}}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="ciudad" class="d-inline font-verdana-bg">
                            <b>DISTRITO/CIUDAD</b>&nbsp;<span
                                style="font-size:10px; color: red;">*</span>
                        </label>
                        <textarea name="ciudad" cols="1" rows="2" class="form-control form-control-sm font-verdana-bg"
                            id="ciudad" onchange="javascript:this.value=this.value.toUpperCase();">{{$solicitud->ciudad}}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label for="telefonosol" class="d-inline font-verdana-bg">
                            <b>TELEFONO/CELULAR:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="telefonosol" class="form-control form-control-sm font-verdana-bg"
                            id="telefonosol" value="{{$solicitud->telefonosol}}" >
                    </div>



                    <div class="col-md-6">
                        <label for="correosol" class="d-inline font-verdana-bg">
                            <b>E-MAIL</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>



                        <input id="correosol" type="text" class="form-control form-control-sm font-verdana-bg"
                            name="correosol" onkeypress="return validarCorreo(correo);" value="{{$solicitud->correosol}}">




                    </div>

                    <div class="col-md-6">
                        <label for="idrubro" class="d-inline font-verdana-bg">
                            <b>RUBRO:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <select name="idrubro" id="idrubro" placeholder="--Seleccionar--"
                            class="form-control form-control-sm select">
                            <option value="">-</option>
                            @foreach ($rubros as $rub)

                                @if ($solicitud->idrubro==$rub->idrubro)
                                <option value="{{ $rub->idrubro }}" selected>{{ $rub->nombrerubro }}</option>
                                @else
                                <option value="{{ $rub->idrubro }}">{{ $rub->nombrerubro }}</option>
                                @endif


                            @endforeach
                        </select>
                    </div>





                    <div class="col-md-3">
                        <label for="cantidad" class="d-inline font-verdana-bg">
                            <b>CANTIDAD DE STANDS</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <select name="cantidad" id="cantidad" placeholder="--Seleccionar--"
                            class="form-control form-control-sm select">

                            @if ($solicitud->stand == "1")
                            <option value="1" selected>1</option>
                            @else
                            <option value="1">1</option>
                            @endif

                            @if ($solicitud->stand == "2")
                            <option value="2" selected>2</option>
                            @else
                            <option value="2">2</option>
                            @endif

                            @if ($solicitud->stand == "3")
                            <option value="3" selected>3</option>
                            @else
                            <option value="3">3</option>
                            @endif

                            @if ($solicitud->stand == "4")
                            <option value="4" selected>4</option>
                            @else
                            <option value="4">4</option>
                            @endif

                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="unidsep" class="d-inline font-verdana-bg">
                            <b>SEPARADOS O UNIDOS</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <select name="unidsep" id="unidsep" placeholder="--Seleccionar--"
                            class="form-control form-control-sm select">

                            @if ($solicitud->unidsep == "1")
                            <option value="1" selected>UNIDOS</option>
                            @else
                            <option value="1">UNIDOS</option>
                            @endif

                            @if ($solicitud->unidsep == "2")
                            <option value="2" selected>SEPARADOS</option>
                            @else
                            <option value="2">SEPARADOS</option>
                            @endif



                        </select>
                    </div>

                </div>


            </div>
            <label for="representante" class="d-inline font-verdana-bg">
                <b>DATOS DEL REPRESENTANTE</b>&nbsp;<span style="font-size:10px; color: red;"></span>
            </label>
            <div class="body-border" style="background-color: #FFFFFF;">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="representante" class="d-inline font-verdana-bg">
                            <b>NOMBRE DEL REPRESENTANTE LEGAL ASOCIACION O INSTITUCION</b>&nbsp;<span
                                style="font-size:10px; color: red;">*</span>
                        </label>
                        <textarea name="representante" cols="1" rows="2" class="form-control form-control-sm font-verdana-bg"
                            id="representante" onchange="javascript:this.value=this.value.toUpperCase();">{{$solicitud->representante}}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label for="cirepresentante" class="d-inline font-verdana-bg">
                            <b>C.I. DELREPRESENTANTE</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="cirepresentante" class="form-control form-control-sm font-verdana-bg"
                            id="cirepresentante" onchange="javascript:this.value=this.value.toUpperCase();" value="{{$solicitud->cirepresentante}}">
                    </div>


                </div>


                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="nombrerecibo" class="d-inline font-verdana-bg">
                            <b>RECIBO A NOMBRE DE:</b>&nbsp;<span
                                style="font-size:10px; color: red;">*</span>
                        </label>
                        <textarea name="nombrerecibo" cols="1" rows="2" class="form-control form-control-sm font-verdana-bg"
                            id="nombrerecibo" onchange="javascript:this.value=this.value.toUpperCase();">{{$solicitud->recibonombre}}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label for="cirecibo" class="d-inline font-verdana-bg">
                            <b>RECIBO CI:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                        </label>
                        <input type="text" name="cirecibo" class="form-control form-control-sm font-verdana-bg"
                            id="cirecibo" onchange="javascript:this.value=this.value.toUpperCase();" value="{{$solicitud->reciboci}}">
                    </div>


                </div>
            </div>

            <div align='center'>

                <div class="body-border col-md-4" style="background-color: #FFFFFF;">

                    <div class="form-group row">
                        <div class="col-md-12    text-right">
                            <button class="btn btn-danger font-verdana-bg" type="button" onclick="cancelar();">

                                <a style="color:white">Cancelar</a>
                            </button>
                            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send"
                                style="display: none;"></i>

                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

                            <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                                <i class="fa-solid fa-paper-plane"></i>
                                Actualizar
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

        function message_alert(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function save() {
            if (validar_formulario() == true) {
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function cancelar() {
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ url('expochaco/index') }}";
        }

        function validar_formulario() {
            if ($("#nombresol").val() == "") {
                message_alert("El campo <b>[NOMBRES Y APELLIDOS]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#asociacionsol>option:selected").val() == "") {
                message_alert("El campo <b>[ASOCIACION]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#ci").val() == "") {
                message_alert("El campo <b>[C.I No]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#direccionsol").val() == "") {
                message_alert("El campo <b>[DIRECCION]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#ciudad").val() == "") {
                message_alert("El campo <b>[DISTRITO/CIUDAD]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#telefonosol").val() == "") {
                message_alert("El campo <b>[TELEFONO]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#correosol").val() == "") {
                message_alert("El campo <b>[CORREO]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#idrubro >option:selected").val() == "") {
                message_alert("El campo de seleccion <b>[RUBRO]</b> es un dato obligatorio...");
                return false;
            }


            return true;
        }

        function valideNumber(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if (code >= 48 && code <= 57) {
                return true;
            } else {
                return false;
            }
        }

        /*var permission_select = new SlimSelect({
            select: '#permissions-select select',
            //showSearch: false,
            placeholder: 'Select Permissions',
            deselectLabel: '<span>&times;</span>',
            hideSelectedOption: true,
        });
        var permission_select2 = new SlimSelect({
            select: '#permissions-select2 select',
            //showSearch: false,
            placeholder: 'Select Permissions',
            deselectLabel: '<span>&times;</span>',
            hideSelectedOption: true,
        });
        var permission_select = new SlimSelect({
            select: '#permissions-select3 select',
            //showSearch: false,
            placeholder: 'Select Permissions',
            deselectLabel: '<span>&times;</span>',
            hideSelectedOption: true,
        });
        var permission_select2 = new SlimSelect({
            select: '#permissions-select4 select',
            //showSearch: false,
            placeholder: 'Select Permissions',
            deselectLabel: '<span>&times;</span>',
            hideSelectedOption: true,
        });*/
    </script>
@endsection
