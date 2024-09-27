<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Kardex</title>
    <style>
        html {
            margin: 30px 50px 50px 55px;
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            background-color: #ffffff;
            }

            .border-bottom {
                border-bottom: 1px solid #000000;
                border-collapse: collapse;
            }

            .border-top {
                border-top: 1px solid #000000;
                border-collapse: collapse;
            }

            .border-right {
                border-right: 1px solid #000000;
                border-collapse: collapse;
            }

            .table-titulo,
            .table-titulo th,
            .table-titulo td {
                border-collapse: collapse;
                width: 100%;
                padding: 1px;
            }

            .table-encabezado {
                border: 1px solid #000000;
                border-collapse: collapse;
                width: 100%;
            }

            .table-encabezado th,
            .table-encabezado td {
                border-collapse: collapse;
                padding: 4px;
                font-size: 9px;
            }

            .table-contenido {
                /* border: 1px solid #000000; */
                border-collapse: collapse;
                width: 100%;
                font-size: 9px;
            }

            .table-contenido th,
            .table-contenido td {
                border-collapse: collapse;
                padding: 3px;
                font-size: 9px;
                vertical-align: top;
            }

            .table-contenido tr:nth-child(even){background-color: #f2f2f2;}

            .table-contenido tr:hover {background-color: #ddd;}

            .logo-gran-chaco{
                width: 160px;
                height:auto;
                border-radius: 10%;
                overflow: hidden;
                opacity: 0.3;
            }

            .logo-nueva-historia{
                width: 100px;
                height:auto;
                border-radius: 10%;
                overflow: hidden;
                opacity: 0.3;
            }

            .icono-check{
                width: 10px;
                height:auto;
                border-radius: 10%;
                overflow: hidden;
            }

            .icono-uncheck{
                width: 10px;
                height:auto;
                border-radius: 10%;
                overflow: hidden;
            }

            .foto-pdf-show{
                width: 100px;
                height:auto;
                border-radius: 10%;
                overflow: hidden;
            }
    </style>
    <body>
        <table class="table-titulo">
            <tr>
                <td width="30%">
                    <img src="{{ public_path('logos/gobiernoregional.jpg') }}" class="logo-gran-chaco" alt="#"/>
                </td>
                <td width="40%" align="center" style="font-size: 14px; vertical-align: bottom;">
                    <b><u>KARDEX</u></b>
                    <br>
                    <span style="font-size: 12px; vertical-align: bottom;">
                        {{ $empleado->ap_pat . ' ' . $empleado->ap_mat . ' ' . $empleado->nombres }}
                    </span>
                    <br>
                    <b style="font-size: 12px; vertical-align: bottom;">{{ $empleado->status_completo }}</b>
                </td>
                <td width="30%" align="right">
                    <img src="{{ public_path('logos/mapa.png') }}" class="logo-nueva-historia" alt="#"/>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    @if ($empleado->url_foto != null)
                        <img src="{{ public_path($empleado->url_foto) }}" class="foto-pdf-show" alt="#"/>
                    @endif
                </td>
            </tr>
        </table>
        <table class="table-contenido">
            <tbody>
                <tr>
                    <td colspan="3" align="center" class="border-bottom">
                        <b>DATOS PERSONALES</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>N° File:</b>&nbsp;{{ $empleado->filecontrato }}
                    </td>
                    <td>
                        <b>Nro. Carnet:</b>&nbsp;{{ $empleado->ci . ' ' . $empleado->extension }}
                    </td>
                    <td>
                        <b>Grado academico:</b>&nbsp;{{ $empleado->gradacademico }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Natalicio:</b>&nbsp;{{ $empleado->natalicio != null ? \Carbon\Carbon::parse($empleado->natalicio)->format('d/m/Y') : '' }}
                    </td>
                    <td>
                        <b>RAE:</b>&nbsp;{{ $empleado->rae }}
                    </td>
                    <td>
                        <b>Registro Profesional:</b>&nbsp;{{ $empleado->regprofesional }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Cuenta Banco Union:</b>&nbsp;{{ $empleado->cuentabanco }}
                    </td>
                    <td>
                        <b>N° Libreta Militar:</b>&nbsp;{{ $empleado->servmilitar }}
                    </td>
                    <td>
                        <b>NIT:</b>&nbsp;{{ $empleado->nit }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Idioma Principal:</b>&nbsp;{{ $empleado->idioma }}
                    </td>
                    <td>
                        <b>KUA:</b>&nbsp;{{ $empleado->kua }}
                    </td>
                    <td>
                        <b>Años de servicio:</b>&nbsp;{{ $empleado->aservicios }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Sigep:</b>&nbsp;
                        @if ($empleado->sigep == '1')
                            <img src="{{ public_path('images/check.jpg') }}" class="icono-check" alt="#"/>
                        @else
                            <img src="{{ public_path('images/uncheck.jpg') }}" class="icono-uncheck" alt="#"/>
                        @endif
                    </td>
                    <td>
                        <b>Inamovilidad:</b>&nbsp;
                        @if ($empleado->inamovilidad == '1')
                            <img src="{{ public_path('images/check.jpg') }}" class="icono-check" alt="#"/>
                        @else
                            <img src="{{ public_path('images/uncheck.jpg') }}" class="icono-uncheck" alt="#"/>
                        @endif
                    </td>
                    <td>
                        <b>Curriculum Vitae:</b>&nbsp;
                        @if ($empleado->cvitae == '1')
                            <img src="{{ public_path('images/check.jpg') }}" class="icono-check" alt="#"/>
                        @else
                            <img src="{{ public_path('images/uncheck.jpg') }}" class="icono-uncheck" alt="#"/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <b>Celular:</b>&nbsp;
                        {{ $empleado->telefono }}
                    </td>
                </tr>
            </tbody>
        </table>
        @foreach ($empleados_contratos as $empleado_contrato)
            <table class="table-contenido">
                <thead>
                    <td colspan="3" align="center" class="border-bottom">
                        <b>
                            DATOS LABORALES
                        </b>
                    </td>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            <b>
                                {{ $empleado->area->nombrearea }} -
                                {{ $empleado_contrato->file != null ? $empleado_contrato->file->nombrecargo : '' }} -
                                {{ $empleado_contrato->escala_salarial != null ? $empleado_contrato->escala_salarial->nombre : '#' }}
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Fecha de ingreso:</b>&nbsp;
                            {{ $empleado_contrato->fecha_ingreso != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_ingreso)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                        <td>
                            <b>Tipo:</b>&nbsp;
                            {{ $empleado_contrato->tipos }}
                        </td>
                        <td>
                            <b>Fecha de retiro:</b>&nbsp;
                            {{ $empleado_contrato->fecha_retiro != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_retiro)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Causa del retiro:</b>&nbsp;
                            {{ $empleado_contrato->obs_retiro }}
                        </td>
                        <td>
                            <b>N° contrato:</b>&nbsp;
                            {{ $empleado_contrato->ncontrato }}
                        </td>
                        <td>
                            <b>N° Preventivo:</b>&nbsp;
                            {{ $empleado_contrato->npreventivo }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Seguro Salud:</b>&nbsp;
                            {{ $empleado_contrato->segsalud }}
                        </td>
                        <td>
                            <b>Biometrico:</b>&nbsp;
                            {{ $empleado_contrato->biometrico }}
                        </td>
                        <td>
                            <b>REJAP:</b>&nbsp;
                            @if ($empleado_contrato->rejap == '1')
                                <img src="{{ public_path('images/check.jpg') }}" class="icono-check" alt="#"/>
                            @else
                                <img src="{{ public_path('images/uncheck.jpg') }}" class="icono-uncheck" alt="#"/>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>POAI:</b>&nbsp;
                            @if ($empleado_contrato->poai == '1')
                                <img src="{{ public_path('images/check.jpg') }}" class="icono-check" alt="#"/>
                            @else
                                <img src="{{ public_path('images/uncheck.jpg') }}" class="icono-uncheck" alt="#"/>
                            @endif
                            &nbsp;&nbsp;&nbsp;
                            <b>Exp.</b>&nbsp;
                            {{ $empleado_contrato->exppoai != null ? \Carbon\Carbon::parse($empleado_contrato->exppoai)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                        <td>
                            <b>Declaracion jurada:</b>&nbsp;
                            @if ($empleado_contrato->decjurada == '1')
                                <img src="{{ public_path('images/check.jpg') }}" class="icono-check" alt="#"/>
                            @else
                                <img src="{{ public_path('images/uncheck.jpg') }}" class="icono-uncheck" alt="#"/>
                            @endif
                            &nbsp;&nbsp;&nbsp;
                            <b>Exp.</b>&nbsp;
                            {{ $empleado_contrato->expdecjurada != null ? \Carbon\Carbon::parse($empleado_contrato->expdecjurada)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                        <td>
                            <b>SIPPASE:</b>&nbsp;
                            @if ($empleado_contrato->sippase == '1')
                                <img src="{{ public_path('images/check.jpg') }}" class="icono-check" alt="#"/>
                            @else
                                <img src="{{ public_path('images/uncheck.jpg') }}" class="icono-uncheck" alt="#"/>
                            @endif
                            &nbsp;&nbsp;&nbsp;
                            <b>Exp.</b>&nbsp;
                            {{ $empleado_contrato->expsippase != null ? \Carbon\Carbon::parse($empleado_contrato->expsippase)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Induccion:</b>&nbsp;
                            @if ($empleado_contrato->induccion == '1')
                                <img src="{{ public_path('images/check.jpg') }}" class="icono-check" alt="#"/>
                            @else
                                <img src="{{ public_path('images/uncheck.jpg') }}" class="icono-uncheck" alt="#"/>
                            @endif
                            &nbsp;&nbsp;&nbsp;
                            <b>Exp.</b>&nbsp;
                            {{ $empleado_contrato->expinduccion != null ? \Carbon\Carbon::parse($empleado_contrato->expinduccion)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                        <td>
                            <b>Programacion vacacion:</b>&nbsp;
                            @if ($empleado_contrato->progvacacion == '1')
                                <img src="{{ public_path('images/check.jpg') }}" class="icono-check" alt="#"/>
                            @else
                                <img src="{{ public_path('images/uncheck.jpg') }}" class="icono-uncheck" alt="#"/>
                            @endif
                            &nbsp;&nbsp;&nbsp;
                            <b>Expiracion:</b>&nbsp;
                            {{ $empleado_contrato->expprogvacacion != null ? \Carbon\Carbon::parse($empleado_contrato->expprogvacacion)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
        @endforeach
    </body>
</html>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $pdf->text(40, 765, "{{ date('d/m/Y H:i') }} | {{ strtoupper($username) }}", "sans-serif", 6);
            $pdf->text(555, 765, "$PAGE_NUM de $PAGE_COUNT", "sans-serif", 6);
        ');
    }
</script>
