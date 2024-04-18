@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row font-verdana">
        <div class="col-md-6  text-left titulo">

            Configuraciones
        </div>
        <div class="col-md-6 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('descuentos.index')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
    </div>
    <div class="row font-verdana-bg">

        <div class="col-md-12">
            <hr class="hrr">
        </div>

    </div>

    <div class="row font-verdana-bg">

        <div class="col-md-5 center">
            <div class="card">
                <div class="card-header titulo">
                    <div class="row font-verdana-bg">
                        <div class="col-md-9 titulo">
                            <b>Lista de Descuentos por Retraso Haber Básico</b>
                        </div>
                        <div class="col-md-3 text-right">
                            <a href="{{ route('descuentos.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar Nuevo Descuento">
                                <button class="btn btn-sm btn-primary font-verdana" type="button">
                                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                                </button>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <table id="descuentos-table" class="table-bordered yajra-datatable hoverTable table display responsive font-verdana" style="width:100%; margin: 0 auto;">

                        <thead>
                            <tr>

                                <th>Días Descuento (Haber Básico)</th>
                                <th>Tiempo Acumulado (Minutos) </th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="row font-verdana-bg">
                        <div class="col-md-12">
                            <hr class="hrr">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="row font-verdana-md">
                <div class="col-md-12 center">

                    <div class="card">
                        <div class="card-header titulo">
                            <div class="row font-verdana-bg">
                                <div class="col-md-8 titulo">
                                    <b>Jornada Laboral</b>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="row font-verdana-sm text-right">

                                        @if(!$HorarioConfig)
                                        &nbsp;

                                        <a class="tts:left tts-slideIn tts-custom" aria-label="Agregar Configuracion">
                                            <button type="button" class="btn btn-success btn-sm font-verdana" aria-label=" Modificar" data-toggle="modal" data-target="#miModalCreate">
                                                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                                            </button>
                                        </a>

                                        @endif
                                        @if($HorarioConfig)
                                        &nbsp;

                                        <a class="tts:left tts-slideIn tts-custom" aria-label="Configurar Jornada">
                                            <button type="button" class="btn btn-info btn-sm font-verdana" aria-label=" Modificar" data-toggle="modal" data-target="#miModalUpdate">

                                                &nbsp;<i class="fas fa-lg  fa-gear"></i>&nbsp;
                                            </button>
                                        </a>
                                        @endif

                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="card-body">
                            <div class="form-group row font-verdana-sm ">

                                <div class="col-md-6 table-responsive center">
                                    <div class="form-group">
                                        <label for="minima"><b>Horas de Jornada Mínima:</b></label>
                                        <input type="text" id="minima" name="minima" class="form-control form-control-sm" maxlength="1" autofocus value="{{ $HorarioConfig ? $HorarioConfig->jornadamin : 'No existe' }}" readonly disabled max="8" min="4">
                                        @error('minima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">El tiempo de jornada minima debe estar en 4.</small>

                                    </div>
                                </div>

                                <div class="col-md-6 table-responsive center">
                                    <div class="form-group">
                                        <label for="maxima"><b>Horas de Jornada Máxima:</b></label>
                                        <input type="text" id="maxima" name="maxima" class="form-control form-control-sm" maxlength="2" autofocus value="{{ $HorarioConfig ? $HorarioConfig->jornadamax : 'No existe' }}" readonly disabled max="12" min="8">
                                        @error('maxima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">El tiempo de marcado debe estar en 8.</small>
                                    </div>
                                </div>

                            </div>




                        </div>
                    </div>

                </div>
            </div>
            <div class="row font-verdana-md">
                <div class="col-md-12 center">

                    <div class="card">
                        <div class="card-body">

                            <div class="form-group row font-verdana-sm ">

                                <div class="col-md-6 table-responsive center">
                                    <div class="form-group">
                                        <label for="minima"><b>Hora de Inicio para Jornada Laboral:</b></label>
                                        <input type="time" id="inicio" name="inicio" class="form-control form-control-sm" value="{{ $HorarioConfig ? $HorarioConfig->iniciomax : '--:--' }}" readonly disabled min="00:00" max="05:00">
                                        @error('time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">La Hora de marcado debe estar entre 00:00 y 05:00 .</small>

                                    </div>
                                </div>

                                <div class="col-md-6 table-responsive center">
                                    <div class="form-group">
                                        <label for="maxima"><b>Marcado para Salida y Entrada: </b></label>
                                        <select id="marcado" name="marcado" class="form-control form-control-sm" disabled required>
                                            @if($HorarioConfig)

                                            <option value="15" {{ $HorarioConfig->marcadomax == 15 ? 'selected' : '' }}>15 MINUTOS</option>
                                            <option value="30" {{ $HorarioConfig->marcadomax == 30 ? 'selected' : '' }}>30 MINUTOS</option>
                                            <option value="45" {{ $HorarioConfig->marcadomax == 45 ? 'selected' : '' }}>45 MINUTOS</option>
                                            @endif
                                        </select>
                                        @error('marcado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">El tiempo de marcado debe estar entre 30 y 45. (En minutos)</small>

                                    </div>
                                </div>

                            </div>




                        </div>
                    </div>
                </div>
            </div>

        </div>
        @if($HorarioConfig)

        <div class="col-md-3 ">
            <div class="row font-verdana-md">
                <div class="col-md-12 center">

                    <div class="card">
                        <div class="card-header titulo">
                            <div class="row font-verdana-bg">
                                <div class="col-md-8 titulo">
                                    <b>Permisos</b>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="row font-verdana-sm text-right">

                                        @if(!$HorarioConfig->permisosmensuales)
                                        &nbsp;

                                        <a class="tts:left tts-slideIn tts-custom" aria-label="Agregar Configuracion">
                                            <button type="button" class="btn btn-success btn-sm font-verdana" aria-label=" Modificar" data-toggle="modal" data-target="#miModalCreatePermisos">
                                                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                                            </button>
                                        </a>

                                        @endif
                                        @if($HorarioConfig->permisosmensuales)
                                        &nbsp;

                                        <a class="tts:left tts-slideIn tts-custom" aria-label="Configurar Jornada">
                                            <button type="button" class="btn btn-info btn-sm font-verdana" aria-label=" Modificar" data-toggle="modal" data-target="#miModalUpdatePermisos">

                                                &nbsp;<i class="fas fa-lg  fa-gear"></i>&nbsp;
                                            </button>
                                        </a>
                                        @endif

                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="card-body">
                            <div class="col-md-12 center">

                                <div class="form-group row font-verdana-sm ">

                                    <div class="col-md-12 table-responsive center">
                                        <div class="form-group">
                                            <label for="minima"><b>Horas de Permisos Mensuales:</b></label>
                                            <select id="dia" name="permisosmensuales" class="form-control" required disabled>

                                                <option value="60" {{ $HorarioConfig->permisosmensuales == 60 ? 'selected' : '' }}>1 HORA</option>
                                                <option value="120" {{ $HorarioConfig->permisosmensuales == 120 ? 'selected' : '' }}>2 HORAS</option>

                                            </select>
                                            @error('minima')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Las horas por defecto de permisos son 2 horas.</small>

                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>


                    </div>
                    <div class="card">
                        <div class="card-header titulo">
                            <div class="row font-verdana-bg">
                                <div class="col-md-8 titulo">
                                    <b>Licencias</b>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="row font-verdana-sm text-right">

                                        @if(!$HorarioConfig->licenciasrip)
                                        &nbsp;

                                        <a class="tts:left tts-slideIn tts-custom" aria-label="Agregar Configuracion">
                                            <button type="button" class="btn btn-success btn-sm font-verdana" aria-label=" Modificar" data-toggle="modal" data-target="#miModalCreateLicencias">
                                                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                                            </button>
                                        </a>

                                        @endif
                                        @if($HorarioConfig->licenciasrip)
                                        &nbsp;

                                        <a class="tts:left tts-slideIn tts-custom" aria-label="Configurar Jornada">
                                            <button type="button" class="btn btn-info btn-sm font-verdana" aria-label=" Modificar" data-toggle="modal" data-target="#miModalUpdateLicencias">

                                                &nbsp;<i class="fas fa-lg  fa-gear"></i>&nbsp;
                                            </button>
                                        </a>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="col-md-12 center">

                                <div class="form-group row font-verdana-sm ">

                                    <div class="col-md-12 table-responsive center">
                                        <div class="form-group">
                                            <label for="minima"><b>Días de Licencia RIP:</b></label>
                                            <select id="licenciasrip" name="licenciasrip" class="form-control form-control-sm" readonly disabled>
                                                <option value="48" {{ $HorarioConfig->licenciasrip == 48 ? 'selected' : '' }}>2 DÍAS</option>
                                                <option value="72" {{ $HorarioConfig->licenciasrip == 72 ? 'selected' : '' }}>3 DÍAS</option>
                                                <option value="96" {{ $HorarioConfig->licenciasrip == 96 ? 'selected' : '' }}>4 DÍAS</option>
                                            </select>
                                            @error('minima')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">El día debe estar en 4.</small>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Botón para abrir el modal -->
<!-- Modal -->
@if($HorarioConfig)

<div class="modal fade" id="miModalUpdate" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <!-- Aquí colocarías tus inputs dentro del formulario -->
                <form method="POST" action="{{ route('descuentos.configUpdate', $HorarioConfig->id)}}">
                    @csrf
                    @method('PUT')

                    <div class="modal-header font-verdana-sm titulo">
                        <h5 class="modal-title" id="miModalLabel">Configurar Jornada Laboral</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row font-verdana-sm ">

                            <div class="col-md-6 table-responsive center">
                                <div class="form-group">
                                    <label for="minima"><b>Horas de Jornada Mínima:</b></label>
                                    <input type="number" id="minima" name="minima" class="form-control form-control-sm" maxlength="1" autofocus value="{{ $HorarioConfig->jornadamin }}" max="8" min="4">
                                    @error('minima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">El tiempo de jornada minima debe estar en 4.</small>

                                </div>
                            </div>

                            <div class="col-md-6 table-responsive center">
                                <div class="form-group">
                                    <label for="maxima"><b>Horas de Jornada Máxima:</b></label>
                                    <input type="number" id="maxima" name="maxima" class="form-control form-control-sm" maxlength="2" autofocus value="{{ $HorarioConfig->jornadamax }}" max="12" min="8">
                                    @error('maxima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">El tiempo de marcado debe estar entre 8 .</small>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row font-verdana-sm ">

                            <div class="col-md-6 table-responsive center">
                                <div class="form-group">
                                    <label for="inicio"><b>Hora Inicio de Jornada Laboral:</b></label>
                                    <input type="time" id="inicio" name="inicio" class="form-control form-control-sm" value="{{ $HorarioConfig->iniciomax }}" min="00:00" max="05:00">
                                    @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">La Hora de marcado debe estar entre 00:00 y 05:00 .</small>

                                </div>
                            </div>

                            <div class="col-md-6 table-responsive center">
                                <div class="form-group">
                                    <label for="marcado"><b>Tiempo de Marcado Máxima:</b></label>
                                    <select id="marcado" name="marcado" class="form-control form-control-sm" required>

                                        <option value="15" {{ $HorarioConfig->marcadomax == 15 ? 'selected' : '' }}>15 MINUTOS</option>
                                        <option value="30" {{ $HorarioConfig->marcadomax == 30 ? 'selected' : '' }}>30 MINUTOS</option>
                                        <option value="45" {{ $HorarioConfig->marcadomax == 45 ? 'selected' : '' }}>45 MINUTOS</option>

                                    </select>
                                    @error('marcado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">El tiempo de marcado debe estar entre 30 y 45.</small>

                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- Aquí colocarías tus inputs dentro del formulario -->


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endif
@if(!$HorarioConfig)

<div class="modal fade" id="miModalCreate" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('descuentos.config') }}">
                @csrf

                <div class="modal-header font-verdana-sm titulo">
                    <h5 class="modal-title" id="miModalLabel">Configurar Jornada Laboral</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row font-verdana-sm ">

                        <div class="col-md-6 table-responsive center">
                            <div class="form-group">
                                <label for="minima"><b>Horas de Jornada Mínima:</b></label>
                                <input type="number" id="minima" name="minima" class="form-control form-control-sm" maxlength="1" autofocus value="{{ old('minima') }}" max="8" min="4">
                                @error('minima')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">El tiempo de jornada minima debe estar en 4.</small>

                            </div>
                        </div>

                        <div class="col-md-6 table-responsive center">
                            <div class="form-group">
                                <label for="maxima"><b>Horas de Jornada Máxima:</b></label>
                                <input type="number" id="maxima" name="maxima" class="form-control form-control-sm" maxlength="2" autofocus value="{{ old('maxima') }}" max="12" min="8">
                                @error('maxima')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">El tiempo de marcado debe estar entre 8.</small>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row font-verdana-sm ">

                        <div class="col-md-6 table-responsive center">
                            <div class="form-group">
                                <label for="inicio"><b>Hora Inicio de Jornada Laboral:</b></label>
                                <input type="time" id="inicio" name="inicio" class="form-control form-control-sm" value="{{ old('inicio') }}" min="00:00" max="05:00">
                                @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">La Hora de marcado debe estar entre 00:00 y 05:00 .</small>

                            </div>
                        </div>

                        <div class="col-md-6 table-responsive center">
                            <div class="form-group">
                                <label for="marcado"><b>Tiempo de Marcado Máxima:</b></label>
                                <input type="number" id="marcado" name="marcado" class="form-control form-control-sm" maxlength="2" value="{{ old('marcado') }}" max="45" min="30">
                                @error('marcado')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">El tiempo de marcado debe estar entre 30 y 45.</small>

                            </div>
                        </div>

                    </div>

                </div>
                <!-- Aquí colocarías tus inputs dentro del formulario -->


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>

                </div>
            </form>

        </div>
    </div>
</div>
@endif
                                      @if($HorarioConfig)

@if(!$HorarioConfig->permisosmensuales)

<div class="modal fade" id="miModalCreatePermisos" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('permisospersonales.config') }}">
                @csrf

                <div class="modal-header font-verdana-sm titulo">
                    <h5 class="modal-title" id="miModalLabel">Configurar Permisos Mensuales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row  font-verdana-sm ">

                        <div class="col-md-12 table-responsive center">
                            <div class="form-group">
                                <label for="permisosmensuales"><b>Horas de Permisos Mensuales</b></label>
                                <select id="dia" name="permisosmensuales" class="form-control" required>

                                    <option value="60" {{ $HorarioConfig->permisosmensuales == 60 ? 'selected' : '' }}>1 HORA</option>
                                    <option value="120" {{ $HorarioConfig->permisosmensuales == 120 ? 'selected' : '' }}>2 HORAS</option>

                                </select>
                                @error('minima')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Por defecto se establece 2 horas mensuales.</small>

                            </div>
                        </div>
                    </div>


                </div>
                <!-- Aquí colocarías tus inputs dentro del formulario -->


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>

                </div>
            </form>

        </div>
    </div>
</div>
@endif
@if($HorarioConfig->permisosmensuales)

<div class="modal fade" id="miModalUpdatePermisos" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('permisospersonales.configUpdate', $HorarioConfig->id)}}">
                @csrf
                @method('PUT')

                <div class="modal-header font-verdana-sm titulo">
                    <h5 class="modal-title" id="miModalLabel">Configurar Boletas Personales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row  font-verdana-sm ">

                        <div class="col-md-12 table-responsive center">
                            <div class="form-group">
                                <label for="permisosmensuales"><b>Horas de Permisos Mensuales</b></label>
                                <select id="dia" name="permisosmensuales" class="form-control" required>

                                    <option value="60" {{ $HorarioConfig->permisosmensuales == 60 ? 'selected' : '' }}>1 HORA</option>
                                    <option value="120" {{ $HorarioConfig->permisosmensuales == 120 ? 'selected' : '' }}>2 HORAS</option>

                                </select>
                                @error('minima')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Por defecto se establece 2 horas mensuales.</small>

                            </div>
                        </div>
                    </div>


                </div>
                <!-- Aquí colocarías tus inputs dentro del formulario -->


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>

                </div>
                <!-- Aquí colocarías tus inputs dentro del formulario -->
            </form>

        </div>
    </div>
</div>
@endif
@if(!$HorarioConfig->licenciasrip)

<div class="modal fade" id="miModalCreate" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('descuentos.config') }}">
                @csrf

                <div class="modal-header font-verdana-sm titulo">
                    <h5 class="modal-title" id="miModalLabel">Configurar Licencias Rip </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row font-verdana-sm ">

                        <div class="col-md-12 table-responsive center">
                            <div class="form-group">
                                <label for="minima"><b>Horas de Jornada Mínima:</b></label>
                                <input type="number" id="minima" name="minima" class="form-control form-control-sm" maxlength="1" autofocus value="{{ old('minima') }}" max="8" min="4">
                                <select id="licenciasrip" name="licenciasrip" class="form-control form-control-sm" required>

                                    <option value="48" {{ $HorarioConfig->licenciasmensuales == 48 ? 'selected' : '' }}>2 DÍAS</option>
                                    <option value="72" {{ $HorarioConfig->licenciasmensuales == 72 ? 'selected' : '' }}>3 DÍAS</option>
                                    <option value="96" {{ $HorarioConfig->licenciasmensuales == 96 ? 'selected' : '' }}>4 DÍAS</option>

                                </select>
                                @error('minima')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">El tiempo de jornada minima debe estar en 4.</small>

                            </div>
                        </div>



                    </div>


                </div>
                <!-- Aquí colocarías tus inputs dentro del formulario -->


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>

                </div>
            </form>

        </div>
    </div>
</div>
@endif
@if($HorarioConfig->licenciasrip)

<div class="modal fade" id="miModalUpdateLicencias" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('licenciaspersonales.configUpdate', $HorarioConfig->id)}}">
                @csrf
                @method('PUT')

                <div class="modal-header font-verdana-sm titulo">
                    <h5 class="modal-title" id="miModalLabel">Configurar Licencias RIP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row font-verdana-sm ">

                        <div class="col-md-12 table-responsive center">
                            <div class="form-group">
                                <label for="minima"><b>Días de Licencia segun RIP</b></label>
                                <select id="licenciasrip" name="licenciasrip" class="form-control form-control-sm" required>

                                    <option value="48" {{ $HorarioConfig->licenciasrip == 2 ? 'selected' : '' }}>2 DÍAS</option>
                                    <option value="72" {{ $HorarioConfig->licenciasrip == 3 ? 'selected' : '' }}>3 DÍAS</option>
                                    <option value="96" {{ $HorarioConfig->licenciasrip == 4 ? 'selected' : '' }}>4 DÍAS</option>

                                </select>
                                @error('minima')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Los por defecto son 2 días de Licencia .</small>

                            </div>
                        </div>



                    </div>


                </div>
                <!-- Aquí colocarías tus inputs dentro del formulario -->


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>

                </div>
            </form>

        </div>
    </div>
</div>
@endif
@endif
@section('scripts')
<script>
    $(document).ready(function() {
        $('#descuentos-table').DataTable({
            serverSide: true,
            processing: true,
            language: {
                info: "<span class='font-verdana'>Mostrando _START_ al _END_ de _TOTAL_</span>",
                search: '',
                searchPlaceholder: "Buscar",
                paginate: {
                    next: "<span class='font-verdana'><b>Siguiente</b></span>",
                    previous: "<span class='font-verdana'><b>Anterior</b></span>",
                },
                lengthMenu: "<span class='font-verdana'>Mostrar </span>" +
                    "<select class='form form-control-sm'>" +
                    "<option value='15'>15</option>" +
                    "<option value='50'>50</option>" +
                    "<option value='100'>100</option>" +
                    "<option value='-1'>Todos</option>" +
                    "</select> <span class='font-verdana'>Registros </span>",
                loadingRecords: "<span class='font-verdana'>...Cargando...</span>",
                processing: "<span class='font-verdana'>...Procesando...</span>",
                emptyTable: "<span class='font-verdana'>No hay datos</span>",
                zeroRecords: "<span class='font-verdana'>No hay resultados para mostrar</span>",
                infoEmpty: "<span class='font-verdana'>Ningun registro encontrado</span>",
                infoFiltered: "<span class='font-verdana'>(filtrados de un total de _MAX_ registros)</span>"
            },
            ajax: "{{ route('descuentos.index') }}",
            columns: [{

                    data: 'descripcion',
                    name: 'descripcion',
                    className: 'text-center p-1 ',

                },
                {

                    data: 'tiempo',
                    name: 'tiempo',
                    className: 'text-center p-1 ',
                },
                {

                    className: 'text-center p-1 ',
                    data: 'actions',
                    name: 'actions',

                }
            ],
            order: [
                [2, 'asc'] // Ordenar por la primera columna ('created_at') de manera ascendente
            ],
            // Ordenar por la primera columna ('created_at') de manera ascendente



        });
        $('#descuentos-table').on('draw.dt', function() {
            $('ul.pagination').addClass('pagination-sm');
        }).DataTable();
    });
</script>
@endsection
@endsection