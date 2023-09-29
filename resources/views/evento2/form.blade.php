@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')

@if (count($errors) > 0)
  <div class="alert alert-danger">
   <button type="button" class="close" data-dismiss="alert">×</button>
   <ul>
    @foreach ($errors->all() as $error)
     <li>{{ $error }}</li>
    @endforeach
   </ul>
  </div>
 @endif
 @if ($message = Session::get('success'))
 <div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
 </div>
 @endif
<br>
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row font-verdana-bg">
                <div class="col-md-4 titulo">

                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/Evento2/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>

                </div>

                <div class="col-md-8 text-right titulo">
                    <b>CARGAR EVENTO</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>
            </div>


            <div class="body-border">
                <font size="2" face="Courier New">
                    <form action="{{ asset('/Evento2/create') }}" method="post" id="form">
                        @csrf
                        <input type="date" class="form-control" name="fecha" value="{{ $fecha}}" hidden>
                        <input type="text" class="form-control" hidden name="usuario" value="{{ $personal->nombres}} {{ $personal->ap_pat}} {{ $personal->ap_mat}}" >

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Agendado por:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" disabled name="usuario2" value="{{ $personal->nombres}} {{ $personal->ap_pat}} {{ $personal->ap_mat}}" >

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Fecha:</label>

                            <div class="col-md-6">
                                <input type="date2" class="form-control col-md-4" name="fecha2" value="{{ $fecha}}" disabled>

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Hora:</label>
                            <div class="col-md-2">
                                <input type="time" name="hora"  class="form-control form-control-sm font-verdana-bg" id="hora" >
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Evento:</label>

                            <div class="col-md-7">
                                <textarea type="text" name="titulo" class="form-control " placeholder="Evento..."  id="titulo"
                                     cols="50" rows="3" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Detalles:</label>

                            <div class="col-md-7">
                                <textarea type="text" name="descripcion" class="form-control " placeholder="Detalles..."  id="descripcion"
                                     cols="50" rows="5" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Lugar:</label>

                            <div class="col-md-7">
                                <textarea type="text" name="lugar" class="form-control " placeholder="Lugar..."  id="lugar"
                                     cols="50" rows="2" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Coordinar con:</label>

                            <div class="col-md-7">
                                <textarea type="text" name="coordinar" class="form-control " placeholder="Coordinar con..."  id="coordinar"
                                     cols="50" rows="2" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Representante G.A.R.G.CH.:</label>

                            <div class="col-md-7">
                                <textarea type="text" name="representante" class="form-control " placeholder="Representante G.A.R.G.CH..."  id="representante"
                                    cols="50" rows="2" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                            </div>
                        </div>


                        <div align='center'>


                            <button class="btn btn-success font-verdana-bg" type="button" id="cancelar">
                                Cancelar
                            </button>

                            &nbsp;&nbsp;&nbsp;&nbsp;

                            <button class="btn color-icon-2 font-verdana-bg" type="button" id="insertar_item_material">
                                <i class="fa-solid fa-paper-plane"></i>
                                Guardar
                            </button>

                            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send"
                                style="display: none;"></i>

                        </div>
                    </form>

                </font>

            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>


        $("#insertar_item_material").click(function() {
            if (validar_detalle_material() == true) {

                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        });


        $("#cancelar    ").click(function() {

            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{url('/Evento2/index')}}";

        });



        function validar_detalle_material() {



            if ($("#hora").val() == "") {
                alert('---EL CAMPO HORA ES OBLIGATORIO---');
                return false;
            }

            if ($("#titulo").val() == "") {
                alert('---EL CAMPO EVENTO NO PUEDE ESTAR VACIO---');
                return false;
            }

            if ($("#descripcion").val() == "") {
                alert('---EL CAMPO DETALLES NO PUEDE ESTAR VACIO---');
                return false;
            }

            if ($("#lugar").val() == "") {
                alert('---EL CAMPO LUGAR NO PUEDE ESTAR VACIO---');
                return false;
            }
            if ($("#coordinar").val() == "") {
                alert('---EL CAMPO COORDINAR CON, NO PUEDE ESTAR VACIO---');
                return false;
            }
            if ($("#representante").val() == "") {
                alert('---EL CAMPO REPRESENTANTE NO PUEDE ESTAR VACIO---');
                return false;
            }






            return true;
        };


    </script>
@endsection
