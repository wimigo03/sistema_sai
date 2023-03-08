@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
        <div class="card-header bg-gradient-secondary text-white rounded d-flex flex-row-reverse"><font size="3" ><strong>AGREGAR REGISTRO</strong></font></div>            <div class="row">
                <a href="{{ url()->previous() }}" class="btn blue darken-4 text-black "><i
                        class="fa fa-plus-square" style="color:#55CE63;font-weight: bold;"></i> Volver atras</a>
            </div>

            <div class="card-body">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('areas.guardarfile2') }}">
                    @csrf
                    <input type="text" hidden class="form-control" name="idarea" placeholder="" value="{{$idarea}}">


                    <div class="form-group row">
                        <label for="numfile" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Numero File') }}</label>

                        <div class="col-md-2">
                            <input type="number" required name="numfile" class="form-control"
                                >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cargo" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>

                        <div class="col-md-6">
                            <input type="text" required name="cargo" class="form-control"
                                placeholder="Cargo..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombrecargo" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Nombre Cargo') }}</label>

                        <div class="col-md-6">
                            <input type="text" required name="nombrecargo" class="form-control"
                                placeholder="Nombre Cargo..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="habbasico" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Haber Basico') }}</label>

                        <div class="col-md-2">
                            <input type="number" placeholder="0" step="0" required name="habbasico"
                                class="form-control" placeholder="Haber Basico...">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="categoria"  style="color:#009EFB;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                        <div class="col-md-4">
                            <select name="categoria" class="form-control">
                            <option value="">==Seleccione una Categoria==</option>
                                <option value="SUPERIOR">Superior</option>
                                <option value="EJECUTIVO">Ejecutivo</option>
                                <option value="OPERATIVO">Operativo</option>

                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="niveladm"  style="color:#009EFB;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">{{ __('Nivel Admin.') }}</label>
                        <div class="col-md-4">
                            <select name="niveladm" class="form-control">
                            <option value="">==Seleccione un Nivel Adm.==</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="clase"  style="color:#009EFB;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">{{ __('Clase') }}</label>
                        <div class="col-md-4">
                            <select name="clase" class="form-control">
                            <option value="">==Seleccione una Clase==</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                               
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="nivelsal"  style="color:#009EFB;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">{{ __('Nivel Salar.') }}</label>
                        <div class="col-md-4">
                            <select name="nivelsal" class="form-control">
                            <option value="">==Seleccione un Nivel Sal.==</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>

                            </select>
                        </div>
                    </div>

                    


                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-outline-success">
                                {{ __('Guardar') }}
                            </button>
                        </div>
                    </div>
                </form>
                </font>


            </div>
        </div>
    </div>
</div>

@endsection