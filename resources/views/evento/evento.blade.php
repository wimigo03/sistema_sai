@extends('layouts.admin')
@section('content')
    @include('layouts.message_alert')
    @if (Session::has('message'))
        <div class="alert alert-success">
            <em> {!! session('message') !!}</em>
        </div>
    @endif
    <br>


    <div align='center'>
        <div class="col-md-6 table-responsive">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('/Evento/index') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
            <a class="btn btn-default" href="{{ asset('/Evento/form/') }}/{{ $date }}"><b style="color:blue">Crear un
                    evento

                        <a href="{{ asset('/Evento/details2/') }}/{{$date}}" target="_blank">
                            <span class="text-primary" >
                                <i class="fa fa-print fa-1x" style="color:rgb(20, 215, 85)"></i>
                            </span>
                        </a>
                    </span></b>

            </a>

            <div align="center">




               {{ $fechaliteral }}
            </div>
            <hr>
            <table id="dataTable" class="table display table-bordered responsive font-verdana;" style="width:100%;">

                <tbody>

                    @forelse ($event as $evento)
                        <tr>
                            <td class="text-justify p-1">
                                <div align='center'>
                                    <a href="{{ asset('/Evento/actualizar/') }}/{{ $evento->id }}">
                                        <span class="text-warning">
                                            <i class="fas fa-xl fa-edit" style="color:rgb(26, 162, 16)"></i>
                                        </span>
                                    </a>
                                </div>
                                <font style="color: blue;font-weight: bold;">Fecha:</font>
                                <br>
                                {{$evento->fecha}}
                                <br>
                                <font style="color: blue;font-weight: bold;">Evento:</font>
                                <br>
                                {{$evento->titulo}}
                                <br>
                                <font style="color: blue;font-weight: bold;">Detalle:</font>
                                <br>
                                {{$evento->descripcion }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Hora:</font>
                                <br>
                                {{ Carbon\Carbon::parse($evento->horaini)->format('H:i') }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Lugar:</font>
                                <br>
                                {{$evento->lugar }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Coordinar con:</font>
                                <br>
                                {{$evento->coordinar }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Representante G.A.R.G.CH.:</font>
                                <br>
                                {{$evento->representante }}
                                <br>

                                <hr>
                            </td>

                        </tr>

                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
@endsection
