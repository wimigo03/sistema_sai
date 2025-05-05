@extends('layouts.dashboard')

@section('content')

<div>
    <div>
        <div class="card">
            <div class="card-header">Nuevo Responsable

            </div>
            <div class="row">
                <a href="{{url()->previous()}}" class="btn blue darken-4 text-black "><i style="color:#55CE63;font-weight: bold;" class="fa fa-plus-square"></i> Volver atras</a>
            </div>

            <div class="card-body">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('contrato.guardar') }}">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="idarea" value="{{$area->nombre}}">
                        <div class="form-group row">
                            <label for="entidad" style="color:black;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">ENTIDAD:</label>
                            <div class="col-md-2">
                                <input type="text" required name="entidad" class="form-control" readonly="true" value="{{$entidad->entidad}}" placeholder="entidad..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="col-md-3">
                                <input type="text" required name="sigla" class="form-control" readonly="true" value="{{$entidad->sigla_ent}}" placeholder="entidad..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="unidad" style="color:black;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">UNIDAD :</label>
                            <div class="col-md-2">
                                <input type="text" required name="unidad" class="form-control" readonly="true" value="{{$unidad->unidad}}" placeholder="entidad..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="col-md-4">
                                <input type="text" required name="unidad-nombre" class="form-control" readonly="true" value="{{$unidad->descrip}}" placeholder="entidad..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="entidad" style="color:black;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">OFICINA:</label>
                            <div class="col-md-2">
                                <input type="text" required name="" class="form-control" readonly="true" value="{{$area->nombrearea}}" placeholder="entidad..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="col-md-3">
                                <input type="text" required name="" class="form-control" readonly="true" value="{{$area->idarea}}" placeholder="entidad..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="codemp" style="color:black;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">RESPOSABLE :</label>
                            <select name="idfile" id="permissions2" class="col-md-6">
                                @foreach ($area as $responsable)
                                <option>
                                    <h1 color:blue;>

                                    @endforeach
                            </select>



                        </div>





                        <div class="form-group row">
                            <label for="cargo" style="color:black;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">CARGO:</label>

                            <div class="col-md-6">
                                <input type="text" required name="cargo" class="form-control" placeholder="cargo..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ci" style="color:black;font-weight: bold;" class="required col-md-4 col-form-label text-md-right">C.I.:</label>

                            <div class="col-md-6">
                                <input type="text" required name="ci" class="form-control" placeholder="carner de identidad..." onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                        </div>

                        </br>

                        <div class="form-group " style="align:center">


                            <label class="col-md-1" style="color:black;font-weight: bold;">File:</label>
                            <div id="permissions-select2">

                            </div>



                            </br>






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