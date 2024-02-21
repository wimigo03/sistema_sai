@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{route('agregar.regulacion', $registroAsistencia->empleado_id)}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>

            <b>Regularizar Asistencia Marcada</b>
        </div>


        <div class="col-md-4 text-right">

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        </div>
    </div>
    <!-- Campos del formulario -->
    <div class="row font-verdana-sm">
        <div class="col-md-6 table-responsive center">
            @if($registroAsistencia->horario->tipo == 0)
            <div class="body-border ">
                <div class="row">
                    <div class="form-group col-md-12 form-check">
                        <b>TURNO CONTINUO :</b>
                        <hr class="hrr">
                        <div class="row">
                            <div class="form-group col-md-6 form-check-sm">
                                <br><b>MARCADO DE ENTRADA:</b></br>
                                <label for="asignado" id="label1">Biometrico</label>
                                <input type="checkbox" name="asignado" id="asignado1" class="form-control" onclick="toggleLabel('label1', 'asignado1', 'registroH_inicio', 'registro_inicio')">
                                <input type="time" id="registroH_inicio" name="registro_entrada" class="form-control" value="{{ $registroAsistencia->horario->hora_inicio }}" required disabled>

                            </div>
                            <div class="form-group col-md-6 form-check">
                                <br><b>MARCADO DE SALIDA:</b></br>
                                <label for="asignado" id="label4">Biometrico</label>
                                <input type="checkbox" name="asignado" id="asignado4" class="form-control" onclick="toggleLabel2('label4', 'asignado4','registroH_final','registro_final')">
                                <input type="time" id="registroH_final" name="registro_final" class="form-control" value="{{ $registroAsistencia->horario->hora_final}}" required disabled>
                            </div>
                        </div>

                    </div>


                    <div class="form-group col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12 form-check">
                                <b>REGULARIZADO :</b>

                                <hr class="hrr">
                            </div>
                        </div>

                        <div class="row">

                            <!-- Agrega más campos según sea necesario -->
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault">
                                    BOLETA OFICIAL
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="BOLETA OFICIAL" id="flexCheckDefault">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    COMUNICACIóN INTERNA
                                </label>

                                <input class="form-control checkbox" type="checkbox" value="COMUNICACION INTERNA" id="flexCheckDefault1">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked2">
                                    LICENCIAS
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="LICENCIAS" id="flexCheckChecked2">

                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked3">
                                    VACACIONES
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="VACACIONES" id="flexCheckChecked3">

                            </div>
                        </div>
                        <div class="form-group col-md-12 form-check">
                            <hr class="hr">
                        </div>


                        <div class="row">
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault4">
                                    BAJA MÉDICA
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="BAJA MÉDICA" id="flexCheckDefault4">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked5">
                                    LIC. G/ DE HABERES
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="LICENCIA SIN GOCE DE HABERES" id="flexCheckChecked5">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked6">
                                    ÓRDEN DE SERVICIO
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="ORDEN DE SERVICIO" id="flexCheckChecked6">
                            </div>
                        </div>
                        <div class="form-group col-md-12 form-check">
                            <hr class="hr">
                        </div>
                        <div class="form-group row font-verdana-sm">

                            @if($permiso->count() > 0 && $registroAsistencia->empleado->tipo==1)
                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-sm">
                                    <div class="form-group col-md-4">
                                        <!-- Agrega más campos según sea necesario -->
                                        <div class="form-check">
                                            <label class="form-check-label text-success" for="flexCheckDefault0">
                                                <b>BOLETA PERSONAL</b>
                                            </label>
                                            <input class="form-control checkbox" type="checkbox" value="BOLETA PERSONAL" id="flexCheckDefault0">
                                            <p class="mb-0">{{$sumaPermisos}}</p>

                                        </div>

                                    </div>


                                    <div class="col-md-4 text-md-right">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostraroPermiso">Detalle</button>
                                        <hr class="hrr">
                                        <b>TIENE REGISTRO <br>BOLETA PERSONAL </b>

                                    </div>

                                    <div class="col-md-4 text-md-right">
                                        @if($sumaPermisos < 120) <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistroPermiso">
                                            Agregar
                                            </button>
                                            <hr class="hrr">
                                            <b>DISPONIBLE: </b><br>
                                            <?php
                                            $horas = floor((120 - $sumaPermisos) / 60);
                                            $minutos = $sumaPermisos % 60;
                                            ?>
                                            {{$horas}} horas {{$minutos}} minutos
                                            @endif


                                    </div>
                                </div>
                            </div>

                            @else
                            <div class="form-group row font-verdana-sm">


                                <div class="col-md-3">
                                    <div class="form-check">
                                        <label class="form-check-label text-success" for="flexCheckDefault0">
                                            <b>BOLETA PERSONAL</b>
                                        </label>

                                    </div>
                                    <div class="form-check">
                                        <p class="mb-0">Hoy no hay ningúna Boleta Personal Registrada</p>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-right">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostraroPermiso">Detalle</button>
                                    <hr class="hrr">
                                    <b>HOY NO TIENE REGISTRO</b>

                                </div>
                                <div class="col-md-4 text-md-right">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistroPermiso">Agregar</button>
                                    <hr class="hrr">
                                    <b>Disponible: </b><br>
                                    @php
                                    $horas = floor( (120 - $sumaPermisos) / 60);
                                    $minutos = $sumaPermisos % 60;
                                    @endphp

                                    @if($horas > 0)
                                    {{ $horas }} horas {{ $minutos }} minutos
                                    @else
                                    {{ $minutos }} minutos
                                    @endif
                                </div>

                            </div>

                            @endif
                        </div>
                        <div class="form-group row font-verdana-sm">
                            @if($licencia->count() > 0 && $registroAsistencia->empleado->tipo==1)
                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-sm">
                                    <div class="form-group col-md-4">
                                        <!-- Agrega más campos según sea necesario -->
                                        <div class="form-check">
                                            <label class="form-check-label text-primary" for="flexCheckDefault0">
                                                <b>LICENCIA CARGO RIP</b>
                                            </label>
                                            <input class="form-control checkbox" type="checkbox" value="BOLETA PERSONAL" id="flexCheckDefault0">
                                            <p class="mb-0">{{$sumaLicencias}}</p>

                                        </div>

                                    </div>


                                    <div class="col-md-4 text-md-right">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostraroPermiso">Detalle</button>
                                        <hr class="hrr">
                                        <b>TIENE REGISTRO <br>LICENCIA CARGO RIP </b>

                                    </div>

                                    <div class="col-md-4 text-md-right">
                                        @if($sumaLicencias < 48 && $registroAsistencia->empleado->tipo==1) <hr class="hrr">
                                            <b>DISPONIBLE: </b><br>
                                            <span class="text-white bg-success px-2 py-1 rounded" style="font-size: medium;">
                                                <?php
                                                $dias = floor((48 - $sumaLicencias) / 24);
                                                $minutos = (48 - $sumaLicencias) % 24;

                                                // Genera una representación textual
                                                $texto = '';

                                                if ($dias > 0) {
                                                    $texto .= $dias . ' día' . ($dias > 1 ? 's' : '') . ' ';
                                                }

                                                if ($minutos > 0) {
                                                    $minutos = floor($minutos / 12);
                                                    $texto .= $minutos . ' mediodia' . ($minutos > 1 ? 's' : '');
                                                }

                                                echo $texto;
                                                ?>
                                            </span>
                                            @endif


                                    </div>
                                </div>
                            </div>

                            @else
                            <div class="form-group row font-verdana-sm">


                                <div class="col-md-3">
                                    <div class="form-check">
                                        <label class="form-check-label text-primary" for="flexCheckDefault0">
                                            <b>LICENCIA CARGO RIP</b>
                                        </label>

                                    </div>
                                    <div class="form-check">
                                        <p class="mb-0">Hoy no hay ningúna Boleta Personal Registrada</p>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-right">
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostraroLicencia">Detalle</button>
                                    <hr class="hrr">
                                    <b>HOY NO TIENE REGISTRO</b>

                                </div>
                                <div class="col-md-4 text-md-right">
                                    <hr class="hrr">
                                    <b>DISPONIBLE: </b><br>
                                    <span class="text-white bg-success px-2 py-1 rounded" style="font-size: medium;">
                                        <?php
                                        $dias = floor((48 - $sumaLicencias) / 24);
                                        $minutos = (48 - $sumaLicencias) % 24;

                                        // Genera una representación textual
                                        $texto = '';

                                        if ($dias > 0) {
                                            $texto .= $dias . ' día' . ($dias > 1 ? 's' : '') . ' ';
                                        }

                                        if ($minutos > 0) {
                                            $minutos = floor($minutos / 12);
                                            $texto .= $minutos . ' mediodia' . ($minutos > 1 ? 's' : '');
                                        }

                                        echo $texto;
                                        ?>
                                    </span>


                                </div>


                            </div>

                            @endif

                        </div>

                        <hr class="hrr">
                    </div>
                </div>
            </div>
            @elseif($registroAsistencia->horario->tipo == 1)
            <div class="body-border ">
                <div class="row font-verdana-sm">
                    <div class="form-group col-md-12 form-check">
                        <b>HORARIO :</b>
                        <hr class="hrr">
                        <div class="row">

                            <div class="form-group col-md-6 form-check">
                                <b>TURNO MAÑANA :</b>
                                <div class="row">
                                    <div class="form-group col-md-6 form-check">
                                        <br><b>ENTRADA:</b></br>
                                        <label for="asignado" id="label1">Biometrico</label>
                                        <input type="checkbox" name="asignado" id="asignado1" class="form-control" onclick="toggleLabel('label1', 'asignado1', 'registroH_inicio', 'registro_inicio')">
                                        <input type="time" id="registroH_inicio" name="registro_inicio" class="form-control form-control-sm" value="{{ $registroAsistencia->horario->hora_inicio }}" required disabled>
                                    </div>
                                    <div class="form-group col-md-6 form-check">
                                        <br><b>SALIDA:</b></br>
                                        <label for="asignado" id="label2">Biometrico</label>
                                        <input type="checkbox" name="asignado" id="asignado2" class="form-control" onclick="toggleLabel3('label2', 'asignado2', 'registroH_salida', 'registro_salida')">
                                        <input type="time" id="registroH_salida" name="registro_salida" class="form-control form-control-sm" value="{{ $registroAsistencia->horario->hora_salida }}" required disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 form-check">

                                <b>TURNO TARDE :</b>



                                <div class="row">
                                    <div class="form-group col-md-6 form-check">
                                        <br><b>ENTRADA:</b></br>
                                        <label for="asignado" id="label3">Biometrico</label>
                                        <input type="checkbox" name="asignado" id="asignado3" class="form-control" onclick="toggleLabel4('label3', 'asignado3','registroH_entrada','registro_entrada')">
                                        <input type="time" id="registroH_entrada" name="registro_entrada" class="form-control form-control-sm" value="{{ $registroAsistencia->horario->hora_entrada }}" required disabled>

                                    </div>
                                    <div class="form-group col-md-6 form-check">
                                        <br><b>SALIDA:</b></br>
                                        <label for="asignado" id="label4">Biometrico</label>
                                        <input type="checkbox" name="asignado" id="asignado4" class="form-control" onclick="toggleLabel2('label4', 'asignado4','registroH_final','registro_final')">
                                        <input type="time" id="registroH_final" name="registro_final" class="form-control form-control-sm" value="{{ $registroAsistencia->horario->hora_final}}" required disabled>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12 form-check">
                                <b>REGULARIZADO :</b>

                                <hr class="hrr">
                            </div>
                        </div>

                        <div class="row">

                            <!-- Agrega más campos según sea necesario -->
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault">
                                    BOLETA OFICIAL
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="BOLETA OFICIAL" id="flexCheckDefault">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    COMUNICACIóN INTERNA
                                </label>

                                <input class="form-control checkbox" type="checkbox" value="COMUNICACION INTERNA" id="flexCheckDefault1">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked2">
                                    LICENCIAS
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="LICENCIAS" id="flexCheckChecked2">

                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked3">
                                    VACACIONES
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="VACACIONES" id="flexCheckChecked3">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 form-check">
                                <hr class="hr">
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault4">
                                    BAJA MÉDICA
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="BAJA MÉDICA" id="flexCheckDefault4">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked5">
                                    LIC. G/ DE HABERES
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="LICENCIA SIN GOCE DE HABERES" id="flexCheckChecked5">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked6">
                                    ÓRDEN DE SERVICIO
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="ORDEN DE SERVICIO" id="flexCheckChecked6">
                            </div>
                        </div>
                        <div class="form-group col-md-12 form-check">
                            <hr class="hr">
                        </div>
                        <div class="form-group row font-verdana-sm">
                            @if($permisos->count() > 0 && $registroAsistencia->empleado->tipo == 1)
                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-sm">
                                    <div class="form-group col-md-4">
                                        <!-- Agrega más campos según sea necesario -->
                                        <div class="form-check">
                                            <label class="form-check-label text-success" for="flexCheckDefault0">
                                                <b>BOLETA PERSONAL</b>
                                            </label>
                                            <input class="form-control checkbox" type="checkbox" value="BOLETA PERSONAL" id="flexCheckDefault0" @if($permisos) checked @endif>

                                        </div>
                                    </div>

                                    <div class="col-md-4 text-md-right">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostrarPermiso">Detalles</button>
                                        <hr class="hrr">
                                        <b>TIENE REGISTRO DE <br>BOLETA PERSONAL </b>
                                    </div>

                                    <div class="col-md-4 text-md-right">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistroPermiso">Agregar</button>
                                        <hr class="hrr">
                                        <b>DISPONIBLE: </b><br>
                                        <?php
                                        $horas = floor((120 - $sumaPermisos) / 60);
                                        $minutos = $sumaPermisos % 60;
                                        ?>
                                        {{$horas}} horas {{$minutos}} minutos

                                    </div>
                                </div>
                            </div>

                            @else

                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-bg">


                                    @if($sumaPermisos < 120 && $registroAsistencia->empleado->tipo == 1)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label text-success" for="flexCheckDefault0">
                                                    <b>BOLETA PERSONAL</b>
                                                </label>
                                                <p class="mb-0" style="color: black;">No se tiene Boleta Personal registrada en Hora de Salida</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-right">
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostrarPermiso">Detalles</button>
                                            <hr class="hrr">
                                            <div class="form-check">
                                                <b>DISPONIBLE: </b><br>
                                                <?php
                                                $horas = floor((120 - $sumaPermisos) / 60);
                                                $minutos = $sumaPermisos % 60;
                                                ?>
                                                <p class="mb-0" style="color: green;"> {{$horas}} horas {{$minutos}} minutos</p>

                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-right">
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistroPermiso">Agregar</button>
                                            <hr class="hrr">

                                        </div>
                                        @elseif($sumaPermisos == 120 && $registroAsistencia->empleado->tipo == 1)

                                        <div class="form-group col-md-3">
                                            <!-- Agrega más campos según sea necesario -->
                                            <div class="form-check">
                                                <label class="form-check-label text-success" for="flexCheckDefault0">
                                                    <b>BOLETA PERSONAL</b>
                                                </label>
                                                <p class="mb-0" style="color: red;">Ya ocupó sus Boletas Personales</p>

                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 text-md-right">
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostrarPermiso">Detalles</button>
                                            <hr class="hrr">
                                            <p style="color: red;">Ya ocupó sus Boletas Personales</p>
                                        </div>
                                        <div class="form-group col-md-4 text-md-right">
                                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarPermiso" disabled>Agregar</button>
                                            <hr class="hrr">
                                            <b>DISPONIBLE: </b>
                                            <?php
                                            $horas = floor((120 - $sumaPermisos) / 60);
                                            $minutos = $sumaPermisos % 60;
                                            ?>
                                            <p style="color: red;"> {{$horas}} horas {{$minutos}} minutos</p>


                                        </div>

                                        @endif
                                </div>
                            </div>

                            @endif
                        </div>
                        <div class="form-group row font-verdana-sm">
                            @if($licencia->count() > 0 && $registroAsistencia->empleado->tipo == 1)
                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-sm">
                                    <div class="form-group col-md-4">
                                        <!-- Agrega más campos según sea necesario -->
                                        <div class="form-check">
                                            <label class="form-check-label text-primary" for="flexCheckDefault0">
                                                <b>LICENCIA PERSONAL</b>
                                            </label>
                                            <input class="form-control checkbox" type="checkbox" value="BOLETA PERSONAL" id="flexCheckDefault0" @if($permisos) checked @endif>

                                        </div>
                                    </div>

                                    <div class="col-md-4 text-md-right">
                                         <hr class="hrr">
                                        <b>TIENE REGISTRO DE <br>LICENCIA CARGO RIP </b>
                                    </div>

                                    <div class="col-md-4 text-md-right">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostrarPermiso">Detalles</button>
                                        <hr class="hrr">
                                        <b>DISPONIBLE: </b><br>

                                        <span class="text-white bg-success px-2 py-1 rounded" style="font-size: medium;">
                                            <?php
                                            $dias = floor((48 - $sumaLicencias) / 24);
                                            $minutos = (48 - $sumaLicencias) % 24;

                                            // Genera una representación textual
                                            $texto = '';

                                            if ($dias > 0) {
                                                $texto .= $dias . ' día' . ($dias > 1 ? 's' : '') . ' ';
                                            }

                                            if ($minutos > 0) {
                                                $minutos = floor($minutos / 12);
                                                $texto .= $minutos . ' mediodia' . ($minutos > 1 ? 's' : '');
                                            }

                                            echo $texto;
                                            ?>
                                        </span>



                                    </div>
                                </div>
                            </div>

                            @else

                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-bg">


                                    @if($sumaLicencias < 48 && $registroAsistencia->empleado->tipo == 1)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label text-primary" for="flexCheckDefault0">
                                                    <b>LICENCIA CARGO RIP</b>
                                                </label>
                                                <p class="mb-0" style="color: black;">Hoy no tiene Licencia Personal registrada </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostrarPermiso">Detalles</button>
                                            <hr class="hrr">
                                            <div class="form-check">
                                                <b>DISPONIBLE: </b><br>
                                                <span class="text-white bg-success px-2 py-1 rounded" style="font-size: medium;">
                                                    <?php
                                                    $dias = floor((48 - $sumaLicencias) / 24);
                                                    $minutos = (48 - $sumaLicencias) % 24;

                                                    // Genera una representación textual
                                                    $texto = '';

                                                    if ($dias > 0) {
                                                        $texto .= $dias . ' día' . ($dias > 1 ? 's' : '') . ' ';
                                                    }

                                                    if ($minutos > 0) {
                                                        $minutos = floor($minutos / 12);
                                                        $texto .= $minutos . ' mediodia' . ($minutos > 1 ? 's' : '');
                                                    }

                                                    echo $texto;
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        @elseif($sumaLicencias == 48 && $registroAsistencia->empleado->tipo == 1)

                                        <div class="form-group col-md-3">
                                            <!-- Agrega más campos según sea necesario -->
                                            <div class="form-check">
                                                <label class="form-check-label text-primary" for="flexCheckDefault0">
                                                    <b>LICENCIA CARGO RIP</b>
                                                </label>
                                                <p class="mb-0" style="color: red;">Ya ocupó sus Boletas Personales</p>

                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 text-md-right">
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostrarPermiso">Detalles</button>
                                            <hr class="hrr">
                                            <p style="color: red;">Ya ocupó sus Licencias Personales Cargo RIP</p>
                                        </div>
                                        <div class="form-group col-md-4 text-md-right">
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostrarPermiso">Detalles</button>
                                            <hr class="hrr">
                                            <b>DISPONIBLE: </b>
                                            <span class="text-white bg-danger px-2 py-1 rounded" style="font-size: medium;">
                                        <?php
                                        $dias = floor((48 - $sumaLicencias) / 24);
                                        $minutos = (48 - $sumaLicencias) % 24;

                                        // Genera una representación textual
                                        $texto = '';

                                        if ($dias > 0) {
                                            $texto .= $dias . ' día' . ($dias > 1 ? 's' : '') . ' ';
                                        }

                                        if ($minutos > 0) {
                                            $minutos = floor($minutos / 12);
                                            $texto .= $minutos . ' mediodia' . ($minutos > 1 ? 's' : '');
                                        }

                                        echo $texto;
                                        ?>
                                    </span>


                                        </div>

                                        @endif
                                </div>
                            </div>

                            @endif
                        </div>

                        <hr class="hrr">
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-6 table-responsive center">

            <div class="body-border ">
                <b>DATOS DE REGISTRO DE ASISTENCIA:</b>
                <hr class="hrr">

                <form method="POST" action="{{ route('regularizar_asistencia.update', $registroAsistencia->id) }} " id="actualizarForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group row ">
                        <div class="form-group col-md-8">
                            <label for="descripcion"><b>Nombre Completo :</b></label>
                            <input type="text" name="descripcion" value="{{ $registroAsistencia->empleado->nombres }} {{$registroAsistencia->empleado->ap_pat}} {{$registroAsistencia->empleado->ap_mat}}" class="form-control form-control-sm" readonly>
                            <input type="hidden" name="observ" value="Regularizado" class="form-control form-control-sm" readonly>

                        </div>

                        <div class="form-group col-md-4">
                            <label for="fecha"><b>Fecha de Registro:</b></label>
                            <input type="date" name="fecha" class="form-control form-control-sm" value="{{ $registroAsistencia->asistencia->fecha }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row font-verdana-sm">

                        @if($registroAsistencia->horario->tipo == 0)
                        @if($registroAsistencia->registro_inicio)
                        <div class="form-group col-md-6">
                            <label for="registro_final"><b>MAÑANA</b> </label><br>
                            <label for="registro_inicio"><b>Reg. de Entrada</b></label>
                            <input type="time" id="registro_inicio" name="registro_inicio" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_inicio }}" readonly>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label for="registro_final"><b>MAÑANA</b> </label><br>
                            <label for="registro_inicio"><b>Reg. de Entrada</b></label>
                            <input type="time" id="registro_inicio" name="registro_inicio" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                        @if($registroAsistencia->registro_final)

                        <div class="form-group col-md-6">
                            <label for="registro_final"><b>TARDE</b> </label><br>
                            <label for="registro_final"><b>Reg. de Salida</b> </label>
                            <input type="time" id="registro_final" name="registro_final" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_final }}" readonly>
                        </div>
                        @else

                        <div class="form-group col-md-6">
                            <label for="registro_final"><b>TARDE</b> </label><br>
                            <label for="registro_final"><b>Reg. de Salida</b> </label>
                            <input type="time" id="registro_final" name="registro_final" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                        @else
                        @if($registroAsistencia->registro_inicio)
                        <div class="form-group col-md-3">
                            <label for="registro_final"><b>MAÑANA</b> </label><br>
                            <label for="registro_inicio"><b>Reg. de Entrada</b></label>
                            <input type="time" id="registro_inicio" name="registro_inicio" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_inicio }}" readonly>
                        </div>
                        @else
                        <div class="form-group col-md-3">
                            <label for="registro_final"><b>MAÑANA</b> </label><br>
                            <label for="registro_inicio"><b>Reg. de Entrada</b></label>
                            <input type="time" id="registro_inicio" name="registro_inicio" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                        @if($registroAsistencia->registro_salida)
                        <div class="form-group col-md-3">
                            <label for="registro_final"><b></b> </label><br>
                            <label for="registro_salida">Hora de salida</label>
                            <input type="time" id="registro_salida" name="registro_salida" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_salida }}" readonly required>
                        </div>
                        @else
                        <div class="form-group col-md-3">
                            <label for="registro_final"><b></b> </label><br>
                            <label for="registro_salida">Hora de salida</label>
                            <input type="time" id="registro_salida" name="registro_salida" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                        @if($registroAsistencia->registro_entrada)
                        <div class="form-group col-md-3">
                            <label for="registro_final"><b></b> </label><br>
                            <label for="registro_entrada">Hora de retorno</label>
                            <input type="time" id="registro_entrada" name="registro_entrada" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_entrada }}" readonly required>
                        </div>
                        @else
                        <div class="form-group col-md-3">
                            <label for="registro_final"><b></b> </label><br>
                            <label for="registro_entrada">Hora de retorno</label>
                            <input type="time" id="registro_entrada" name="registro_entrada" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                        @if($registroAsistencia->registro_final)

                        <div class="form-group col-md-3">
                            <label for="registro_final"><b>TARDE</b> </label><br>
                            <label for="registro_final"><b>Reg. de Salida</b> </label>
                            <input type="time" id="registro_final" name="registro_final" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_final }}" readonly>
                        </div>
                        @else

                        <div class="form-group col-md-3">
                            <label for="registro_final"><b>TARDE</b> </label><br>
                            <label for="registro_final"><b>Reg. de Salida</b> </label>
                            <input type="time" id="registro_final" name="registro_final" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                        @endif

                    </div>

                    <div class="col-md-12 form-check">

                        <label for="asignado"><b>OBSERVACIONES:</b></label><br>

                        <input type="hidden" id="observ2" name="observ2" class="form-control form-control-sm" value="{{$registroAsistencia->observ}}">

                        <textarea class="form-control form-control-sm" name="observ" id="exampleTextarea" rows="6" required>{{$registroAsistencia->observ}}</textarea>

                    </div>

                    <div class="col-md-12 text-right">
                        <hr class="hrr">
                        <button type="submit" class="btn btn-success">Regularizar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
</div>




<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarModalLabel">Confirmar Actualización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas actualizar?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmarBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRegistroPermiso" tabindex="-1" aria-labelledby="modalRegistroPermisoLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header font-verdana-bg">
                <h5 class="modal-title" id="modalRegistroPermisoLabel">REGISTRAR BOLETA PERSONAL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body font-verdana-sm">
                <form method="POST" action="{{ route('permisospersonales.store') }}">
                    @csrf
                    <div class="form-group row font-verdana-sm">
                        <div class="col-md-8 ">
                            <label for="empleado_id"><b>Nombres y Apellidos:</b></label>
                            <input type="hidden" name="registroAsistencia_id" value="{{ $registroAsistencia->id }}" readonly class="form-control">

                            <input type="hidden" name="permiso_id" value="{{ $permisoID->id }}" readonly class="form-control">
                            <input type="hidden" name="empleado_id" id="empleado_id" value="{{ $registroAsistencia->empleado->idemp }}" readonly class="form-control ">
                            <input type="text" name="empleado" id="empleado" value="{{$registroAsistencia->empleado->nombres}} {{$registroAsistencia->empleado->ap_pat}} {{$registroAsistencia->empleado->ap_mat}}" readonly class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_solicitud"><b>Fecha de Solicitud:</b></label>

                            <input type="date" name="fecha_solicitud" id="fecha_solicitud" value="{{ $registroAsistencia->asistencia->fecha }}" required readonly class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="permiso_id"><b>1. Motivo:</b></label>
                            <input type="text" name="asunto" value="Personal" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="hora_salida"><b>2. Hora de Salida:</b></label>
                            <input type="time" name="hora_salida_input" id="hora_salida_input" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="duracion"><b>3. Horas Utilizadas:</b></label>
                            <select name="duracion" id="duracion" class="form-control" required>
                                @for ($i = 0; $i <= 120 - $sumaPermisos; $i +=30) @php $hours=floor($i / 60); $minutes=$i % 60; $hourLabel=($hours===1) ? 'hora' : 'horas' ; $minuteLabel=($minutes===1) ? 'minuto' : 'minutos' ; $durationText='' ; if ($hours> 0) {
                                    $durationText .= "$hours $hourLabel";
                                    }
                                    if ($hours > 0 && $minutes > 0) {
                                    $durationText .= ' y ';
                                    }
                                    if ($minutes > 0) {
                                    $durationText .= "$minutes $minuteLabel";
                                    }
                                    @endphp
                                    <option value="{{ $i }}">{{ $durationText }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="hora_retorno"><b>4. Hora de Retorno:</b></label>
                            <input type="time" name="hora_retorno" id="hora_retorno" required class="form-control">
                        </div>
                    </div>
                    <input type="hidden" name="hora_actual" id="hora_salida" value="{{ date('H:i') }}" required class="form-control">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">REGISTRAR PERMISO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalMostrarPermiso" tabindex="-1" aria-labelledby="modalMostrarPermisoLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header font-verdana-sm">
                <h5 class="modal-title" id="modalRegistroPermisoLabel">REGISTROS DE BOLETA PERSONAL: <p class="mb-0"></p>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body font-verdana-sm">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Fecha de<br> Solicitud</th>
                            <th scope="col">Hora de<br> Salida</th>
                            <th scope="col">Hora de <br> Retorno</th>
                            <th scope="col">Tiempo <br>Utilizado</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($permiso))
                        @if($sumaPermisos < 120) @foreach($permisTotal as $permis) <tr @if($permis->fecha_solicitud == $registroAsistencia->fecha && $registroAsistencia->horario->hora_salida < $permis->hora_retorno) class="table-success" @endif>
                                <td>{{ $permis->fecha_solicitud }}</td>
                                <td>{{ $permis->hora_salida }}</td>
                                <td>{{ $permis->hora_retorno }}</td>
                                <td>
                                    @php
                                    $horas = floor($permis->horas_utilizadas / 60);
                                    $minutos = $permis->horas_utilizadas % 60;
                                    @endphp

                                    @if($horas > 0)
                                    {{ $horas }} horas {{ $minutos }} minutos
                                    @else
                                    {{ $minutos }} minutos
                                    @endif
                                </td>

                                </tr>
                                @endforeach

                                @else
                                @foreach($permisTotal as $permis)
                                <tr @if($permis->fecha_solicitud == $registroAsistencia->fecha && $registroAsistencia->horario->hora_salida < $permis->hora_retorno) class="table-success" @endif>
                                        <td>{{ $permis->fecha_solicitud }}</td>
                                        <td>{{ $permis->hora_salida }}</td>
                                        <td>{{ $permis->hora_retorno }}</td>
                                        <td>
                                            @php
                                            $horas = floor($permis->horas_utilizadas / 60);
                                            $minutos = $permis->horas_utilizadas % 60;
                                            @endphp

                                            @if($horas > 0)
                                            {{ $horas }} horas {{ $minutos }} minutos
                                            @else
                                            {{ $minutos }} minutos
                                            @endif
                                        </td>

                                </tr>
                                @endforeach
                                @endif
                                @endif

                                @if(isset($permisos))
                                @if($sumaPermisos < 120) @foreach($permisTotal as $permis) <tr @if($permis->fecha_solicitud == $registroAsistencia->fecha && $registroAsistencia->horario->hora_salida < $permis->hora_retorno) class="table-success" @endif>
                                        <td>{{ $permis->fecha_solicitud }}</td>
                                        <td>{{ $permis->hora_salida }}</td>
                                        <td>{{ $permis->hora_retorno }}</td>
                                        <td>
                                            @php
                                            $horas = floor($permis->horas_utilizadas / 60);
                                            $minutos = $permis->horas_utilizadas % 60;
                                            @endphp

                                            @if($horas > 0)
                                            {{ $horas }} horas {{ $minutos }} minutos
                                            @else
                                            {{ $minutos }} minutos
                                            @endif
                                        </td>

                                        </tr>
                                        @endforeach

                                        @else
                                        @foreach($permisTotal as $permis)
                                        <tr @if($permis->fecha_solicitud == $registroAsistencia->fecha && $registroAsistencia->horario->hora_salida < $permis->hora_retorno || $permis->fecha_solicitud == $registroAsistencia->fecha && $registroAsistencia->horario->hora_salida < $permis->hora_retorno) class="table-success" @endif>
                                                    <td>{{ $permis->fecha_solicitud }}</td>
                                                    <td>{{ $permis->hora_salida }}</td>
                                                    <td>{{ $permis->hora_retorno }}</td>
                                                    <td>@php
                                                        $horas = floor($permis->horas_utilizadas / 60);
                                                        $minutos = $permis->horas_utilizadas % 60;
                                                        @endphp

                                                        @if($horas > 0)
                                                        {{ $horas }} horas {{ $minutos }} minutos
                                                        @else
                                                        {{ $minutos }} minutos
                                                        @endif


                                                    </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMostrarLicencia" tabindex="-1" aria-labelledby="modalMostrarLicenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header font-verdana-sm">
                <h5 class="modal-title" id="modalRegistroPermisoLabel">REGISTROS DE LICENCIAS RIP: <p class="mb-0"></p>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body font-verdana-sm">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Fecha de<br> Solicitud</th>
                            <th scope="col">Turno</th>
                            <th scope="col">Tiempo <br>Utilizado</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($licencia))
                        @if($sumaLicencias < 48) @foreach($licenciaTotal as $permis) <tr @if($permis->fecha_solicitud == $registroAsistencia->fecha ) class="table-warning" @endif>
                            <td>{{ $permis->fecha_solicitud }}</td>
                            <td>{{ $permis->asunto }}</td>
                            <td>
                                <?php
                                $dias = floor($permis->dias_utilizados / 24);
                                $minutos = $permis->dias_utilizados % 24;

                                // Genera una representación textual
                                $texto = '';

                                if ($dias > 0) {
                                    $texto .= $dias . ' día' . ($dias > 1 ? 's' : '') . ' ';
                                }

                                if ($minutos > 0) {
                                    $minutos = floor($minutos / 12);
                                    $texto .= $minutos . ' mediodia' . ($minutos > 1 ? 's' : '');
                                }

                                echo $texto;
                                ?>
                            </td>

                            </tr>
                            @endforeach

                            @else
                            @foreach($licenciaTotal as $permis)
                            <tr @if($permis->fecha_solicitud == $registroAsistencia->fecha) class="table-warning" @endif>
                                <td>{{ $permis->fecha_solicitud }}</td>
                                <td>{{ $permis->hora_salida }}</td>
                                <td>{{ $permis->hora_retorno }}</td>
                                <td>
                                <td>
                                    <?php
                                    $dias = floor($permis->dias_utilizados / 24);
                                    $minutos = $permis->dias_utilizados % 24;

                                    // Genera una representación textual
                                    $texto = '';

                                    if ($dias > 0) {
                                        $texto .= $dias . ' día' . ($dias > 1 ? 's' : '') . ' ';
                                    }

                                    if ($minutos > 0) {
                                        $minutos = floor($minutos / 12);
                                        $texto .= $minutos . ' mediodia' . ($minutos > 1 ? 's' : '');
                                    }

                                    echo $texto;
                                    ?>
                                </td>

                                </td>

                            </tr>
                            @endforeach
                            @endif
                            @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@section('scripts')



<script>
    // Variable para almacenar el valor original de registro_inicio
    var originalRegistroInicioValue = $("#registro_inicio").val();
    var originalRegistroFinalValue = $("#registro_final").val();
    var originalRegistroSalidaValue = $("#registro_salida").val();
    var originalRegistroEntradaValue = $("#registro_entrada").val();

    function toggleLabel(labelId, checkboxId, sourceInputId, targetInputId) {
        // Obtener el texto original del label
        var originalText = $("#" + labelId).text();

        // Verificar el estado actual del checkbox
        var isChecked = $("#" + checkboxId).prop("checked");

        // Cambiar el texto del label según el estado del checkbox
        $("#" + labelId).text(isChecked ? originalText + " (MANUAL)" : originalText.replace(" (MANUAL)", ""));

        // Obtener el valor del input fuente
        var sourceValue = $("#" + sourceInputId).val();

        // Asignar el valor del input fuente al input destino si el checkbox está marcado
        $("#" + targetInputId).val(isChecked ? sourceValue : originalRegistroInicioValue);
    }

    function toggleLabel2(labelId, checkboxId, sourceInputId, targetInputId) {
        // Obtener el texto original del label
        var originalText = $("#" + labelId).text();

        // Verificar el estado actual del checkbox
        var isChecked = $("#" + checkboxId).prop("checked");

        // Cambiar el texto del label según el estado del checkbox
        $("#" + labelId).text(isChecked ? originalText + " (MANUAL)" : originalText.replace(" (MANUAL)", ""));

        // Obtener el valor del input fuente
        var sourceValue = $("#" + sourceInputId).val();

        // Asignar el valor del input fuente al input destino si el checkbox está marcado
        $("#" + targetInputId).val(isChecked ? sourceValue : originalRegistroFinalValue);
    }

    function toggleLabel3(labelId, checkboxId, sourceInputId, targetInputId) {
        // Obtener el texto original del label
        var originalText = $("#" + labelId).text();

        // Verificar el estado actual del checkbox
        var isChecked = $("#" + checkboxId).prop("checked");

        // Cambiar el texto del label según el estado del checkbox
        $("#" + labelId).text(isChecked ? originalText + " (MANUAL)" : originalText.replace(" (MANUAL)", ""));

        // Obtener el valor del input fuente
        var sourceValue = $("#" + sourceInputId).val();

        // Asignar el valor del input fuente al input destino si el checkbox está marcado
        $("#" + targetInputId).val(isChecked ? sourceValue : originalRegistroSalidaValue);
    }

    function toggleLabel4(labelId, checkboxId, sourceInputId, targetInputId) {
        // Obtener el texto original del label
        var originalText = $("#" + labelId).text();

        // Verificar el estado actual del checkbox
        var isChecked = $("#" + checkboxId).prop("checked");

        // Cambiar el texto del label según el estado del checkbox
        $("#" + labelId).text(isChecked ? originalText + " (MANUAL)" : originalText.replace(" (MANUAL)", ""));

        // Obtener el valor del input fuente
        var sourceValue = $("#" + sourceInputId).val();

        // Asignar el valor del input fuente al input destino si el checkbox está marcado
        $("#" + targetInputId).val(isChecked ? sourceValue : originalRegistroEntradaValue);
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var confirmarBtn = document.getElementById('confirmarBtn');
        var confirmarModal = new bootstrap.Modal(document.getElementById('confirmarModal'));
        var registroModal = new bootstrap.Modal(document.getElementById('modalRegistroPermiso'));

        confirmarBtn.addEventListener('click', function() {
            // Simplemente envía el formulario cuando el usuario confirma
            document.forms['actualizarForm'].submit();
            registroModal.hide();
            confirmarModal.hide();
        });

        // Agrega un event listener al formulario para evitar el envío directo
        document.forms['actualizarForm'].addEventListener('submit', function(event) {
            event.preventDefault();
            confirmarModal.show();
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.checkbox').change(function() {
            var text = '';
            $('.checkbox:checked').each(function() {
                text += $(this).val() + '\n';
            });
            $('#exampleTextarea').val(text.trim());
        });
        $('.checkbox').change(function() {
            updateTextarea();
            // Almacenar el estado en el campo oculto
            $('#observ2').val($('#exampleTextarea').val());
        });

        // Leer el valor almacenado en el campo oculto al cargar la página
        var storedValue = $('#observ2').val();
        if (storedValue) {
            // Dividir el valor en líneas y marcar los checkboxes correspondientes
            var lines = storedValue.split('\n');
            lines.forEach(function(line) {
                $('.checkbox[value="' + line.trim() + '"]').prop('checked', true);
            });
            updateTextarea();
        }
    });
</script>
<script>
    // Llamada al modal mediante JavaScript (requiere jQuery en versiones anteriores de Bootstrap)
    $(document).ready(function() {
        $('.btn-primary').click(function() {
            $('#modalRegistroPermiso').modal('show');
        });
        $('.btn-info').click(function() {
            $('#modalMostrarPermiso').modal('show');
        });
        $('.btn-warning').click(function() {
            $('#modalMostrarLicencia').modal('show');
        });
    });

    // Función para redondear la hora al próximo minuto múltiplo de 5
    function roundToNextMultipleOf5() {
        const currentTime = new Date();
        const minutes = currentTime.getMinutes();
        const remainder = minutes % 5;
        if (remainder !== 0) {
            // Redondea al próximo múltiplo de 5
            const roundedMinutes = minutes + (5 - remainder);
            currentTime.setMinutes(roundedMinutes);
        }
        const formattedTime = currentTime.toTimeString().slice(0, 5); // Formato HH:mm
        document.getElementById('hora_salida_input').value = formattedTime;
    }

    // Llama a la función cuando se carga la página
    window.onload = roundToNextMultipleOf5;

    // Función para actualizar el texto de la duración
    function actualizarTextoDuracion() {
        const duracionSelect = document.getElementById('duracion');
        const duracionText = document.getElementById('duracion_text');

        const selectedOption = duracionSelect.options[duracionSelect.selectedIndex];
        if (selectedOption) {
            const selectedText = selectedOption.text;
            duracionText.textContent = selectedText;
        }
    }

    // Escuchar cambios en el selector de duración
    document.getElementById('duracion').addEventListener('change', actualizarTextoDuracion);

    // Función para calcular la hora de retorno
    function calcularHoraRetorno() {
        const horaSalidaInput = document.getElementById('hora_salida_input');
        const duracionSelect = document.getElementById('duracion');
        const horaRetornoInput = document.getElementById('hora_retorno');

        const horaSalida = new Date(`2023-01-01T${horaSalidaInput.value}`);
        const duracion = parseInt(duracionSelect.value);

        if (!isNaN(duracion)) {
            // Sumar la duración en minutos a la hora de salida
            horaSalida.setMinutes(horaSalida.getMinutes() + duracion);

            // Formatear la hora de retorno como "HH:mm"
            const horaRetorno = horaSalida.toTimeString().slice(0, 5);

            // Establecer el valor en el campo de hora de retorno
            horaRetornoInput.value = horaRetorno;
        }
    }

    // Escuchar cambios en la hora de salida y la duración
    document.getElementById('hora_salida').addEventListener('change', calcularHoraRetorno);
    document.getElementById('duracion').addEventListener('change', calcularHoraRetorno);
</script>

@endsection
@endsection