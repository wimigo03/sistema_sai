@extends('layouts.admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
        <div class="card-header bg-gradient-secondary text-white rounded d-flex flex-row-reverse"><font size="3" ><strong>EDITAR REGISTRO</strong></font></div>
            <div class="row">
                <a href="{{ url()->previous() }}" class="btn blue darken-4 text-black "><i class="fa fa-plus-square"
                        style="color:#55CE63;font-weight: bold;"></i> Volver atras</a>
            </div>

            <div class="card-body">
            <font size="2" face="Courier New" >
                <form method="POST" action="{{ route('file2.update') }}">
                    @csrf
                    <input type="text" hidden class="form-control" name="idfile" placeholder=""
                        value="{{$file->idfile}}">
                    <input type="text" hidden class="form-control" name="idarea" placeholder=""
                        value="{{$file->idarea}}">


                    <div class="form-group row">
                        <label for="numfile" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Numero File') }}</label>

                        <div class="col-md-6">
                            <input type="text" required name="numfile" class="form-control" value="{{$file->numfile}}"
                                placeholder="Numero de File...">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cargo" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>

                        <div class="col-md-6">
                            <input type="text" required name="cargo" class="form-control" placeholder="Cargo..."
                                onkeyup="javascript:this.value=this.value.toUpperCase();" value="{{$file->cargo}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombrecargo" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Nombre Cargo') }}</label>

                        <div class="col-md-6">
                            <input type="text" required name="nombrecargo" class="form-control"
                                placeholder="Nombre Cargo..." onkeyup="javascript:this.value=this.value.toUpperCase();"
                                value="{{$file->nombrecargo}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="habbasico" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Haber Basico') }}</label>

                        <div class="col-md-6">
                            <input type="number" placeholder="0" step="0" required name="habbasico" class="form-control"
                                placeholder="Haber Basico..." value="{{$file->habbasico}}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="categoria" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                        <div class="col-md-4">
                            <select name="categoria" class="form-control" value="{{$file->categoria}}">

                                <option value="SUPERIOR">SUPERIOR</option>
                                <option value="EJECUTIVO">EJECUTIVO</option>
                                <option value="OPERATIVO">OPERATIVO</option>

                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="niveladm" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Nivel Admin.') }}</label>
                        <div class="col-md-4">
                            <select name="niveladm" class="form-control">

                                <option {{ ($file->niveladm) == 1 ? 'selected' : '' }} value="1">1</option>
                                <option {{ ($file->niveladm) == 2 ? 'selected' : '' }} value="2">2</option>
                                <option {{ ($file->niveladm) == 3 ? 'selected' : '' }} value="3">3</option>
                                <option {{ ($file->niveladm) == 4 ? 'selected' : '' }} value="4">4</option>
                                <option {{ ($file->niveladm) == 5 ? 'selected' : '' }} value="5">5</option>
                                <option {{ ($file->niveladm) == 6 ? 'selected' : '' }} value="6">6</option>
                                <option {{ ($file->niveladm) == 7 ? 'selected' : '' }} value="7">7</option>
                                <option {{ ($file->niveladm) == 8 ? 'selected' : '' }} value="8">8</option>
                                <option {{ ($file->niveladm) == 9 ? 'selected' : '' }} value="9">9</option>
                                <option {{ ($file->niveladm) == 10 ? 'selected' : '' }} value="10">10</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="clase" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Clase') }}</label>
                        <div class="col-md-4">
                            <select name="clase" class="form-control">

                                <option {{ ($file->clase) == 1 ? 'selected' : '' }} value="1">1</option>
                                <option {{ ($file->clase) == 2 ? 'selected' : '' }} value="2">2</option>
                                <option {{ ($file->clase) == 3 ? 'selected' : '' }} value="3">3</option>
                                <option {{ ($file->clase) == 4 ? 'selected' : '' }} value="4">4</option>
                                <option {{ ($file->clase) == 5 ? 'selected' : '' }} value="5">5</option>
                                <option {{ ($file->clase) == 6 ? 'selected' : '' }} value="6">6</option>
                                <option {{ ($file->clase) == 7 ? 'selected' : '' }} value="7">7</option>
                                <option {{ ($file->clase) == 8 ? 'selected' : '' }} value="8">8</option>
                                <option {{ ($file->clase) == 9 ? 'selected' : '' }} value="9">9</option>

                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="nivelsal" style="color:#009EFB;font-weight: bold;"
                            class="required col-md-4 col-form-label text-md-right">{{ __('Nivel Salar.') }}</label>
                        <div class="col-md-4">
                            <select name="nivelsal" class="form-control">

                                <option {{ ($file->nivelsal) == 1 ? 'selected' : '' }} value="1">1</option>
                                <option {{ ($file->nivelsal) == 2 ? 'selected' : '' }} value="2">2</option>
                                <option {{ ($file->nivelsal) == 3 ? 'selected' : '' }} value="3">3</option>
                                <option {{ ($file->nivelsal) == 4 ? 'selected' : '' }} value="4">4</option>
                                <option {{ ($file->nivelsal) == 5 ? 'selected' : '' }} value="5">5</option>
                                <option {{ ($file->nivelsal) == 6 ? 'selected' : '' }} value="6">6</option>
                                <option {{ ($file->nivelsal) == 7 ? 'selected' : '' }} value="7">7</option>
                                <option {{ ($file->nivelsal) == 8 ? 'selected' : '' }} value="8">8</option>
                                <option {{ ($file->nivelsal) == 9 ? 'selected' : '' }} value="9">9</option>
                                <option {{ ($file->nivelsal) == 10 ? 'selected' : '' }}value="10">10</option>
                                <option {{ ($file->nivelsal) == 11 ? 'selected' : '' }} value="11">11</option>
                                <option {{ ($file->nivelsal) == 12 ? 'selected' : '' }} value="12">12</option>
                                <option {{ ($file->nivelsal) == 13 ? 'selected' : '' }} value="13">13</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="required  col-md-4 col-form-label text-md-right"
                            style="color:#009EFB;font-weight: bold;">{{ __('Area') }}</label>
                        <div class="col-md-8" id="permissions-select">
                            <select name="idarea2" required id="permissions" class="col-md-6">
                                @foreach ($areas as $area)

                                @if ($area->idarea==$file->idarea)
                                <option value="{{$area->idarea}}" selected>{{$area->nombrearea}}</option>
                                @else
                                <option value="{{$area->idarea}}">{{$area->nombrearea}}</option>
                                @endif


                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-outline-success ">
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