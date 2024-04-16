@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row font-verdana-12">
                <div class="col-md-4 titulo">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('Activo/entidad/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>
                        <!-- Vista de retorno (por ejemplo, index.blade.php) -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Resto del contenido de la vista -->
        <!-- Vista de retorno (por ejemplo, index.blade.php) -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <!-- Resto del contenido de la vista -->


        <!-- Mostrar mensaje de error -->
        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
        @endif

                <div class="col-md-8 text-right titulo">
                    <b>CREAR REGISTRO</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>

            </div>




            <div class="body-border">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('activo.entidad.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="gestion" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">gestion :</label>

                            <div class="col-md-6">
                                <input type="text" required name="gestion" class="form-control" placeholder="gestion..."
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="entidad" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">entidad :</label>

                            <div class="col-md-6">
                                <input type="text" required name="entidad" class="form-control" placeholder="entidad..."
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="desc_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">desc_ent:</label>

                            <div class="col-md-6">
                                <input type="text" required name="desc_ent" class="form-control"
                                    placeholder="desc_ent entidad..."
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sigla_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">sigla_ent :</label>

                            <div class="col-md-6">
                                <input type="text" required name="sigla_ent" class="form-control"
                                    placeholder="sigla entidad..."
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sector_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">sector_ent :</label>

                            <div class="col-md-6">
                                <input type="text" required name="sector_ent" class="form-control"
                                    placeholder="sector entidad..."
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subsector_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">subsector_ent :</label>

                            <div class="col-md-6">
                                <input type="text" required name="subsector_ent" class="form-control"
                                    placeholder="subsector entidad..."
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="area_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">area_ent :</label>

                            <div class="col-md-6">
                                <input type="text" required name="area_ent" class="form-control"
                                    placeholder="area entidad..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subarea_ent" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">subarea_ent :</label>

                            <div class="col-md-6">
                                <input type="text" required name="subarea_ent" class="form-control"
                                    placeholder="sub area entidad..."
                                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nivel_inst" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">nivel_inst :</label>

                            <div class="col-md-6">
                                <input type="text" required name="nivel_inst" class="form-control"
                                    placeholder="nivel inst..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>


                        <br>

                        <div align='center'>

                            <button class="btn color-icon-2 font-verdana-12" type="submit">
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
