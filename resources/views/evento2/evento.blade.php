@extends('layouts.dashboard')
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
                <a href="{{ url('/Evento2/index') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
            <a class="btn btn-default" href="{{ asset('/Evento2/form/') }}/{{ $date }}"><b style="color:blue">Crear un
                    evento

                    <a href="{{ asset('/Evento2/details2/') }}/{{ $date }}" target="blank_">
                        <span class="text-primary">
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
                                    <a href="{{ asset('/Evento2/actualizar/') }}/{{ $evento->id }}">
                                        <button class="btn btn-sm btn-light   font-verdana" type="button">
                                            &nbsp;<i class="fas fa-lg fa-edit" style="color: green "
                                                aria-hidden="true"></i>&nbsp;Editar
                                        </button>

                                    </a>
                                    @if ($evento->estadoarchivo == 0)
                                    <a href="{{ route('evento2.cargarpdf', $evento->id ) }}">
                                        <button class="btn btn-sm btn-light   font-verdana" type="button">
                                            &nbsp;<i class="fa fa-lg fa-file-pdf" style="color:red"
                                                aria-hidden="true"></i>&nbsp;Agreg.Digital
                                        </button>

                                    </a>
                                    @elseif ($evento->estadoarchivo == 1)
                                    <a href="{{ route('evento2.urlfile', $evento->id ) }}" target="blank_">
                                        <button class="btn btn-sm btn-light   font-verdana" type="button">
                                            &nbsp;<i class="fa fa-lg fa-eye" style="color: blue "
                                                aria-hidden="true"></i>&nbsp;Ver Archivo
                                        </button>
                                    </a>
                                    <a href="{{ route('evento2.actualizarpdf', $evento->id ) }}">
                                        <button class="btn btn-sm btn-light   font-verdana" type="button">
                                            &nbsp;<i class="fa fa-lg fa-file" style="color: orange"
                                                aria-hidden="true"></i>&nbsp;Cambiar Digital
                                        </button>

                                       </a>
                                    @endif
                                </div>
                                <font style="color: blue;font-weight: bold;">Fecha:</font>
                                <br>
                                {{ $evento->fecha }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Evento:</font>
                                <br>
                                {{ $evento->titulo }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Detalle:</font>
                                <br>
                                {{ $evento->descripcion }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Hora:</font>
                                <br>
                                {{ Carbon\Carbon::parse($evento->horaini)->format('H:i') }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Lugar:</font>
                                <br>
                                {{ $evento->lugar }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Coordinar con:</font>
                                <br>
                                {{ $evento->coordinar }}
                                <br>
                                <font style="color: blue;font-weight: bold;">Representante G.A.R.G.CH.:</font>
                                <br>
                                {{ $evento->representante }}
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
