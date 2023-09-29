@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row font-verdana-bg">
                <div class="col-md-4 titulo">

                    <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                        <a href="{{ url('/agenda/index') }}">
                            <span class="color-icon-1">
                                &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                            </span>
                        </a>
                    </span>

                </div>

                <div class="col-md-8 text-right titulo">
                    <b>EDITAR AGENDA</b>
                </div>

                <div class="col-md-12">
                    <hr color="red">
                </div>
            </div>


            <div class="body-border">
                <font size="2" face="Courier New">
                    <form method="POST" action="{{ route('agenda.update', $agenda->idagenda) }}" enctype="multipart/form-data">
                        @csrf





                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Evento:</label>

                            <div class="col-md-7">
                                <textarea type="text" name="evento" class="form-control" placeholder="Evento..." required id="evento"
                                onchange="javascript:this.value=this.value.toUpperCase();" cols="50" rows="3">{{$agenda->evento}}</textarea>
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="nombre" style="color:black;font-weight: bold;"
                                class="required col-md-4 col-form-label text-md-right">Detalles:</label>

                            <div class="col-md-7">
                                <textarea type="text" name="descripcion" class="form-control" placeholder="Detalles..." required id="descripcion"
                                onchange="javascript:this.value=this.value.toUpperCase();" cols="50" rows="5">{{$agenda->descripcion}}</textarea>
                            </div>
                        </div>


                        <div align='center'>

                            <button class="btn color-icon-2 font-verdana-bg" type="submit">
                                <i class="fa-solid fa-paper-plane"></i>

                                &nbsp;
                                Guardar
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
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

    </script>
@endsection
