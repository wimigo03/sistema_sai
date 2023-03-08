@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">
                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/compras/proveedores/index')}}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            </div>

            <div class="col-md-8 text-right titulo">
                <b>CREAR REGISTRO</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>

        </div>


        <div class="body-border">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('proveedores.store') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="nombre" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Nombre Proveedor:</label>

                        <div class="col-md-6">
                            <input type="text" required name="nombre" class="form-control" placeholder="Nombre..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="representante" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Representante Proveedor:</label>

                        <div class="col-md-6">
                            <input type="text" required name="representante" class="form-control"
                                placeholder="representante..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cedula" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Cedula:</label>

                        <div class="col-md-4">
                            <input type="text" required name="cedula" class="form-control" placeholder="cedula...">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nitci" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Fecha de Expiracion:</label>
                        <div class="col-md-4">
                            <input type="text" name="Ciexpiracion" value="" placeholder="dd/mm/aaaa" class="form-control form-control-sm font-verdana-bg" id="fechainicio" data-language="es" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nitci" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Nit/Ci:</label>

                        <div class="col-md-4">
                            <input type="text" required name="nitci" class="form-control" placeholder="Nit/Ci...">
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="telefono" style="color:black;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">Telefono:</label>

                        <div class="col-md-4">
                            <input type="text" required name="telefono" class="form-control" placeholder="Telefono...">
                        </div>
                    </div>

                    <br>

                        <div align='center'>

                            <button class="btn color-icon-2 font-verdana-bg" type="submit">
                                <i class="fa-solid fa-paper-plane"></i>
                                &nbsp;Registrar
                            </button>
                        </div>

                </form>
            </font>

        </div>

    </div>
</div>

@endsection
@section('scripts')
    <script>




        $("#fechainicio").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });


    </script>
@endsection
