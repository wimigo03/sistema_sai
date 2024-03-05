@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row font-verdana-12">
                <div class="col-md-8 titulo">
                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="javascript:void(0);" onclick="window.history.back()">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>
                </div>
                <div class="col-md-4 text-right titulo">

                    <b>AGREGAR AUXILIAR</b>
                </div>
            </div>
            <div class="col-md-12 font-verdana">
                <hr color="red">
                {{ $entidad->desc_ent }}
            </div>


            <div class="row font-verdana justify-content-center">
                <div class="body-border ">
                    <div class="col-md-12">

                        <form method="POST" action="{{ route('activo.auxiliar.store') }}">
                            @csrf
                            <div class="form-group row font-verdana-sm">

                                <div class="col-md-4">
                                    <label style="color:black;font-weight: bold;">ENTIDAD:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <input type="hidden" name="entidad" value="{{ $entidad->entidad }}"
                                                readonly="true" class="form-control">

                                            <span class="input-group-text">{{ $entidad->entidad }}</span>
                                        </div>
                                        <input type="text" name="sigla" readonly="true" class="form-control"
                                            value="{{ $entidad->sigla_ent }}">
                                    </div>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label style="color:black;font-weight: bold;">UNIDAD :</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <input type="hidden" name="unidad" value="{{ $unidad->unidad }}"
                                                readonly="true" class="form-control" required>

                                            <span class="input-group-text">{{ $unidad->unidad }}</span>
                                        </div>
                                        <input type="text" name="unidad-nombre" readonly="true" class="form-control"
                                            value="{{ $unidad->descrip }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label style="color:black;font-weight: bold;">FECHA :</label>
                                    <div class="input-group">
                                        <input type="date" required name="feult" readonly="true" class="form-control"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label style="color:black;font-weight: bold;">GRUPO CONTABLE:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <input type="hidden" name="codcont" value="{{ $codconts->codcont }}"
                                                readonly="true" class="form-control" required>

                                            <span class="input-group-text">{{ $codconts->codcont }}</span>
                                        </div>
                                        <input type="text" name="cod-nombre" value="{{ $codconts->nombre }}"
                                            readonly="true" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label style="color:black;font-weight: bold;">AUXILIAR :</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <input type="hidden" required name="codaux" value="{{ $newauxiliar }}"
                                                class="form-control" required>
                                            <span class="input-group-text"> {{ $newauxiliar }}</span>
                                        </div>
                                        <input type="text" name="nomaux" class="form-control" required
                                            placeholder="nombre auxiliar..."
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>

                            </div>


                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="observ" style="color:black;font-weight: bold;">OBSERVACIONES :</label>
                                    <textarea type="text" class="form-control" rows="3" name="observ" placeholder="observacion..."
                                        onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                                </div>
                            </div>



                            <div>

                                <button class="btn color-icon-2 font-verdana-12" type="submit">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    &nbsp;Registrar
                                </button>
                            </div>


                        </form>

                    </div>

                </div>

                {{ $usuar }}

            </div>
        </div>
    </div>
@endsection
