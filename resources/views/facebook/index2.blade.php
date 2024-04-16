@extends('layouts.admin')
@section('content')
    @include('layouts.message_alert')
    @if (Session::has('message'))
        <div class="alert alert-success">
            <em> {!! session('message') !!}</em>
        </div>
    @endif
    <div class="row font-verdana-bg">
        <div class="col-md-6 titulo">
            <b>DETALLE DE COMPARTIDOS</b>
        </div>
        <div class="col-md-6 text-right">

            <a href="{{ route('facebook.index') }}" class="tts:left tts-slideIn tts-custom"
                aria-label="Personerias Actualizadas">
                <button class="btn btn-default btn-flat pull-left" type="button">Volver
                    <i class="fa fa-backward" style="font-size:14px"></i>&nbsp;
                </button>
            </a>




        </div>
        <div class="card-body">
            @include('facebook.partials.search')
            <hr class="hrr">
        </div>



    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <!-- Log on to codeastro.com for more projects! -->
                    <table class="table display table-bordered responsive font-verdana" style="width:100%;">

                        <thead>
                            <tr class="font-verdana font-weight-bold">

                                <td class="text-left p-1 ">NOMBRES</td>
                                <td class="text-left p-1">AP.PAT.</td>
                                <td class="text-left p-1">AP.MAT.</td>
                                <td class="text-left p-1">AREA</td>
                                <td class="text-left p-1">NIVEL</td>
                                <td class="text-left p-1">COMPARTE</td>
                                <td class="text-left p-1">ME.GUSTA</td>
                                <td class="text-left p-1">COMENTA</td>
                                <td class="text-center p-1" width="5%"><i class="fa fa-bars" aria-hidden="true" ></i></td>




                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facepubli as $facepublic)
                                <tr>
                                    <form  action="{{ route('facebook.deshabilitar',$facepublic->id) }}" method="POST" id="formu">
                                        @csrf

                                    <td class="text-left p-1">{{ $facepublic->empleado->nombres }}</td>
                                    <td class="text-left p-1"> {{ $facepublic->empleado->ap }}</td>
                                    <td class="text-left p-1">{{ $facepublic->empleado->am }}</td>
                                    <td class="text-left p-1">{{ $facepublic->area->nombrearea  }}</td>
                                    <td class="text-left p-1">{{ $facepublic->nivel->nombrenivel  }}</td>

                                    <td>
                                        <select name="compartido" id="compartido">

                                            <option  value="1" @if($facepublic->compartido == 1) selected @endif >SI</option>
                                            <option  value="2" @if($facepublic->compartido == 2) selected @endif >NO</option>
                                        </select>

                                    </td>
                                    <td>
                                        <select name="megusta" id="megusta">

                                            <option value="1" @if($facepublic->megusta == 1) selected @endif >SI</option>
                                            <option value="2" @if($facepublic->megusta == 2) selected @endif >NO</option>
                                        </select>


                                    </td>
                                    <td>
                                        <select name="like" id="like">

                                            <option value="1" @if($facepublic->like == 1) selected @endif >SI</option>
                                            <option value="2" @if($facepublic->like == 2) selected @endif >NO</option>
                                        </select>

                                    </td>

                                    <td>

                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar Registro">
                                            <button type="submit" class="btn">
                                            <a   class="btn  btn-sm delete btn-flat"><i class='fa fa-check'></i></a>
                                            </button>
                                        </span>

                                    </td>
                                </form>

                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr class="font-verdana">
                                <td colspan="12">
                                    {{ $facepubli->appends(Request::all())->links() }}
                                    <p class="text-muted">Mostrando
                                        <strong>{{ $facepubli->count() }}</strong> registros de
                                        <strong>{{ $facepubli->total() }}</strong> totales
                                    </p>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Log on to codeastro.com for more projects! -->
    </div>
    </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
@section('scripts')
    <script>
         $(document).ready(function() {
            $('#area').select2({
                placeholder: "----- Area - Unidad -----"
            });

            $('#nivell').select2({
                placeholder: "----- Nivel -----"
            });


        });
        function save(){

                $("#form").submit();

        }
        function procesar(){
            var url = "{{ route('facebook.search',$idfacebook) }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function procesar2(){
            var url = "{{ route('facebook.agregarEmpleados',$idfacebook) }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }



        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{ route('facebook.editar',$idfacebook) }}";
        }


    </script>
@endsection
