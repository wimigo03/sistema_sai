<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{--<title></title>--}}
    <style>
        <?php echo file_get_contents(public_path('css/font-verdana-pdf.css')); ?>
    </style>
    <body>
        <table class="table-100">
            <tr>
                <td width="20%">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/gobiernoregional.jpg'))) }}" class="logo-gran-chaco" alt="#"/>
                </td>
                <td class="font-verdana-13 align-center align-inferior">
                    <b>GOBIERNO AUTONOMO REGIONAL DEL GRAN CHACO<br>YACUIBA</b>
                </td>
                <td width="20%" class="align-right">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/logoderecha.png'))) }}" class="logo-nueva-historia" alt="#"/>
                </td>
            </tr>
        </table>
        <br>
        <table class="table-80 font-verdana-11">
            <thead class="bg-color-green">
                <td colspan="2" class="align-center align-middle linea-inferior">
                    <b>{{ $empleado->status }}</b>
                </td>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" class="align-center align-middle">
                        @if ($empleado->url_foto != null)
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($empleado->url_foto))) }}" class="foto-pdf-show" alt="#"/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <b>Apellido Paterno:</b>&nbsp;{{ $empleado->ap_pat }}
                    </td>
                    <td>
                        <b>Grado academico:</b>&nbsp;{{ $empleado->gradacademico }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Apellido Materno:</b>&nbsp;{{ $empleado->ap_mat }}
                    </td>
                    <td>
                        <b>RAE:</b>&nbsp;{{ $empleado->rae }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Nombre Completo:</b>&nbsp;{{ $empleado->nombres }}
                    </td>
                    <td>
                        <b>Registro Profesional:</b>&nbsp;{{ $empleado->regprofesional }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Nro. Carnet:</b>&nbsp;{{ $empleado->ci . ' ' . $empleado->extension }}
                    </td>
                    <td>
                        <b>Cuenta Banco Union:</b>&nbsp;{{ $empleado->cuentabanco }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Natalicio:</b>&nbsp;{{ $empleado->natalicio != null ? \Carbon\Carbon::parse($empleado->natalicio)->format('d/m/Y') : '' }}
                    </td>
                    <td>
                        <b>N° File:</b>&nbsp;{{ $empleado->filecontrato }}
                    </td>
                </tr>
                <tr>
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
                </tr>
                <tr>
                    <td>
                        <b>Años de servicio:</b>&nbsp;{{ $empleado->aservicios }}
                    </td>
                    <td>
                        <b>Sigep:</b>&nbsp;
                        @if ($empleado->sigep == '1')
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/check.jpg'))) }}" class="icono-check" alt="#"/>
                        @else
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uncheck.jpg'))) }}" class="icono-uncheck" alt="#"/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Inamovilidad:</b>&nbsp;
                        @if ($empleado->inamovilidad == '1')
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/check.jpg'))) }}" class="icono-check" alt="#"/>
                        @else
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uncheck.jpg'))) }}" class="icono-uncheck" alt="#"/>
                        @endif
                    </td>
                    <td>
                        <b>Curriculum Vitae:</b>&nbsp;
                        @if ($empleado->cvitae == '1')
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/check.jpg'))) }}" class="icono-check" alt="#"/>
                        @else
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uncheck.jpg'))) }}" class="icono-uncheck" alt="#"/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Celular:</b>&nbsp;
                        {{ $empleado->telefono }}
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        @foreach ($empleados_contratos as $empleado_contrato)
            <table class="table-80 font-verdana-11">
                <thead class="bg-color-green">
                    <td colspan="2" class="align-center align-middle linea-inferior">
                        <b>{{ $empleado_contrato->file->nombrecargo }} - {{ $empleado->area->nombrearea }}</b>
                    </td>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <b>Fecha de ingreso:</b>&nbsp;
                            {{ $empleado_contrato->fecha_ingreso != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_ingreso)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                        <td>
                            <b>Tipo:</b>&nbsp;
                            {{ $empleado_contrato->tipos }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Fecha de retiro:</b>&nbsp;
                            {{ $empleado_contrato->fecha_retiro != null ? \Carbon\Carbon::parse($empleado_contrato->fecha_retiro)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                        <td>
                            <b>Causa del retiro:</b>&nbsp;
                            {{ $empleado_contrato->obs_retiro }}
                        </td>
                    </tr>
                    <tr>
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
                    </tr>
                    <tr>
                        <td>
                            <b>REJAP:</b>&nbsp;
                            @if ($empleado_contrato->rejap == '1')
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/check.jpg'))) }}" class="icono-check" alt="#"/>
                            @else
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uncheck.jpg'))) }}" class="icono-uncheck" alt="#"/>
                            @endif
                        </td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>POAI:</b>&nbsp;
                            @if ($empleado_contrato->poai == '1')
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/check.jpg'))) }}" class="icono-check" alt="#"/>
                            @else
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uncheck.jpg'))) }}" class="icono-uncheck" alt="#"/>
                            @endif
                        </td>
                        <td>
                            <b>Expiracion:</b>&nbsp;
                            {{ $empleado_contrato->exppoai != null ? \Carbon\Carbon::parse($empleado_contrato->exppoai)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Declaracion jurada:</b>&nbsp;
                            @if ($empleado_contrato->decjurada == '1')
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/check.jpg'))) }}" class="icono-check" alt="#"/>
                            @else
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uncheck.jpg'))) }}" class="icono-uncheck" alt="#"/>
                            @endif
                        </td>
                        <td>
                            <b>Expiracion:</b>&nbsp;
                            {{ $empleado_contrato->expdecjurada != null ? \Carbon\Carbon::parse($empleado_contrato->expdecjurada)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>SIPPASE:</b>&nbsp;
                            @if ($empleado_contrato->sippase == '1')
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/check.jpg'))) }}" class="icono-check" alt="#"/>
                            @else
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uncheck.jpg'))) }}" class="icono-uncheck" alt="#"/>
                            @endif
                        </td>
                        <td>
                            <b>Expiracion:</b>&nbsp;
                            {{ $empleado_contrato->expsippase != null ? \Carbon\Carbon::parse($empleado_contrato->expsippase)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Induccion:</b>&nbsp;
                            @if ($empleado_contrato->induccion == '1')
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/check.jpg'))) }}" class="icono-check" alt="#"/>
                            @else
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uncheck.jpg'))) }}" class="icono-uncheck" alt="#"/>
                            @endif
                        </td>
                        <td>
                            <b>Expiracion:</b>&nbsp;
                            {{ $empleado_contrato->expinduccion != null ? \Carbon\Carbon::parse($empleado_contrato->expinduccion)->format('d/m/Y') : 'No corresponde' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Programacion vacacion:</b>&nbsp;
                            @if ($empleado_contrato->progvacacion == '1')
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/check.jpg'))) }}" class="icono-check" alt="#"/>
                            @else
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uncheck.jpg'))) }}" class="icono-uncheck" alt="#"/>
                            @endif
                        </td>
                        <td>
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
{{--<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("verdana");
            $pdf->text(30, 590, "{{ date('d-m-Y H:i') }} / {{ Auth()->user()->name }}", $font, 7);
            $pdf->text(720, 590, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 7);
        ');
    }
</script>--}}
