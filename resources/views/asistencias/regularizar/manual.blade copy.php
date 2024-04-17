@if($registroAsistencia->horario->tipo == 0)
        <div class="col-md-3">
            <div class="body-border ">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="form-group row font-verdana-sm">
                            @if($permiso->count() > 0 && $registroAsistencia->empleado->tipo==1)
                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-sm">
                              

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
                            @if($registroAsistencia->empleado->tipo==1)

                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-sm">
                                
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

                            </div>
                            @endif
                            @endif
                        </div>
                        <div class="form-group row font-verdana-sm">
                            @if($licencia->count() > 0 && $registroAsistencia->empleado->tipo==1)
                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-sm">
                                 

                                    <div class="col-md-4 text-md-right">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostraroPermiso">Detalle</button>
                                        <hr class="hrr">
                                        <b>TIENE REGISTRO <br>LICENCIA CARGO RIP </b>

                                    </div>

                                    <div class="col-md-4 text-md-right">
                                        @if($sumaLicencias < 48 && $registroAsistencia->empleado->tipo==1)
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
                                            @endif


                                    </div>
                                </div>
                            </div>
                            @else
                            @if($registroAsistencia->empleado->tipo==1)

                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-sm">

 
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

                            </div>
                            @endif
                            @endif

                        </div>

                        <hr class="hrr">
                    </div>
                </div>
            </div>
        </div>
        @elseif($registroAsistencia->horario->tipo == 1)
        <div class="col-md-3">
            <div class="body-border ">
                <div class="row font-verdana-sm">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12 form-check">
                            <hr class="hr">
                        </div>
                        <div class="form-group row font-verdana-sm">
                            @if($permisos->count() > 0 && $registroAsistencia->empleado->tipo == 1)
                            <div class="form-group col-md-12 ">
                                <div class="form-group row font-verdana-sm">
                               
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

                                      
                                        <div class="form-group col-md-4 text-md-right">
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostrarPermiso">Detalles</button>
                                            <hr class="hrr">
                                            <p style="color: red;">Ya ocupó sus Licencias Personales Cargo RIP</p>
                                        </div>
                                        <div class="form-group col-md-4 text-md-right">
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalMostrarLicencia">Detalles</button>
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
        </div>
        @endif