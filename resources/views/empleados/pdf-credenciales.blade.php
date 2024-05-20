<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{--<title></title>--}}
    <style>
        <?php echo file_get_contents(public_path('css/credenciales.css')); ?>
    </style>
    <body>
        <table class="table-border-100">
            @if (isset($empleados))
                @php
                    $i = 0;
                @endphp
                @while ($i < count($empleados))
                    <tr>
                        <td>
                            <table class="table-border-i-100">
                                <tr>
                                    <td class="align-center" style="background:#00A553;">
                                        <br>
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/gobiernoregional.png'))) }}" alt="#" class="logo-gobierno-regional"/>
                                        <div class="table-container-empleado">
                                            @if ($empleados[$i]->url_foto)
                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($empleados[$i]->url_foto))) }}" alt="#" class="logo-empleado"/>
                                            @else
                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/d3.jpg'))) }}" alt="#" class="logo-empleado"/>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-center font-verdana-11">
                                        {{ $empleados[$i]->ci != null ? $empleados[$i]->ci . ' ' . $empleados[$i]->extension : '0000000-??' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-center font-verdana-11 table-container-name">
                                        @if ($empleados[$i]->nombres != null)
                                            <b>{{ ucwords(mb_strtolower($empleados[$i]->nombres, 'UTF-8')) . ' ' . ucwords(mb_strtolower($empleados[$i]->ap_pat, 'UTF-8')) . ' ' . ucwords(mb_strtolower($empleados[$i]->ap_mat, 'UTF-8')) }}</b>
                                        @else
                                            ???
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-center font-verdana-10 table-container-cargo">
                                        {{ $empleados[$i]->file_cargo }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-center table-container-nueva-historia">
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/logoderecha.jpg'))) }}" alt="#" class="logo-nueva-historia"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-center font-verdana-7 table-container-area">
                                        {{ $empleados[$i]->area->nombrearea }}
                                        <div class="table-container-pie">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/pie-pagina-credencial.jpg'))) }}" alt="#" class="pie-pagina-credencial"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        @php
                            $i++
                        @endphp
                        @if (isset($empleados[$i]))
                            <td>
                                <table class="table-border-i-100">
                                    <tr>
                                        <td class="align-center" style="background:#00A553;">
                                            <br>
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/gobiernoregional.png'))) }}" alt="#" class="logo-gobierno-regional"/>
                                            <div class="table-container-empleado">
                                                @if ($empleados[$i]->url_foto)
                                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($empleados[$i]->url_foto))) }}" alt="#" class="logo-empleado"/>
                                                @else
                                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/d3.jpg'))) }}" alt="#" class="logo-empleado"/>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-center font-verdana-11">
                                            {{ $empleados[$i]->ci != null ? $empleados[$i]->ci . ' ' . $empleados[$i]->extension : '0000000-??' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-center font-verdana-11 table-container-name">
                                            <b>{{ ucwords(mb_strtolower($empleados[$i]->nombres, 'UTF-8')) . ' ' . ucwords(mb_strtolower($empleados[$i]->ap_pat, 'UTF-8')) . ' ' . ucwords(mb_strtolower($empleados[$i]->ap_mat, 'UTF-8')) }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-center font-verdana-10 table-container-cargo">
                                            {{ $empleados[$i]->file_cargo }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-center table-container-nueva-historia">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/logoderecha.jpg'))) }}" alt="#" class="logo-nueva-historia"/>
                                        </td>
                                    </tr>
                                    <td class="align-center font-verdana-7 table-container-area">
                                        {{ $empleados[$i]->area->nombrearea }}
                                        <div class="table-container-pie">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/pie-pagina-credencial.jpg'))) }}" alt="#" class="pie-pagina-credencial"/>
                                        </div>
                                    </td>
                                </table>
                            </td>
                        @endif
                        @php
                            $i++
                        @endphp
                        @if (isset($empleados[$i]))
                            <td>
                                <table class="table-border-i-100">
                                    <tr>
                                        <td class="align-center" style="background:#00A553;">
                                            <br>
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/gobiernoregional.png'))) }}" alt="#" class="logo-gobierno-regional"/>
                                            <div class="table-container-empleado">
                                                @if ($empleados[$i]->url_foto)
                                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($empleados[$i]->url_foto))) }}" alt="#" class="logo-empleado"/>
                                                @else
                                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/d3.jpg'))) }}" alt="#" class="logo-empleado"/>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-center font-verdana-11">
                                            {{ $empleados[$i]->ci != null ? $empleados[$i]->ci . ' ' . $empleados[$i]->extension : '0000000-??' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-center font-verdana-11 table-container-name">
                                            <b>{{ ucwords(mb_strtolower($empleados[$i]->nombres, 'UTF-8')) . ' ' . ucwords(mb_strtolower($empleados[$i]->ap_pat, 'UTF-8')) . ' ' . ucwords(mb_strtolower($empleados[$i]->ap_mat, 'UTF-8')) }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-center font-verdana-10 table-container-cargo">
                                            {{ $empleados[$i]->file_cargo }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-center table-container-nueva-historia">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/logoderecha.jpg'))) }}" alt="#" class="logo-nueva-historia"/>
                                        </td>
                                    </tr>
                                    <td class="align-center font-verdana-7 table-container-area">
                                        {{ $empleados[$i]->area->nombrearea }}
                                        <div class="table-container-pie">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/pie-pagina-credencial.jpg'))) }}" alt="#" class="pie-pagina-credencial"/>
                                        </div>
                                    </td>
                                </table>
                            </td>
                        @else
                            <td>
                                <table class="table-border-ielse-100">
                                    <tr>
                                        <td>
                                            <div class="table-container-empleado">
                                                &nbsp;
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        @endif
                        @php
                            $i++
                        @endphp
                    </tr>
                @endwhile
            @endif
        </table>
        <div style="page-break-after: always;"></div>
        <table class="table-border-100">
            @if (isset($empleados))
                @php
                    $i = 0;
                @endphp
                @while ($i < count($empleados))
                    <tr style="transform: scaleX(-1)">
                        <td>
                            <table class="table-border-i-100">
                                <tr style="transform: scaleX(-1)">
                                    <td class="table-container-pie">
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/pie-pagina-credencial.jpg'))) }}" alt="#" class="pie-pagina-credencial"/>
                                    </td>
                                </tr>
                                <tr style="transform: scaleX(-1)">
                                    <td class="align-center font-verdana-11">
                                        <p>
                                            Al portador de este credencial se le indentifica como funcionario del <b>Gobierno Autonomo Regional del Gran Chaco</b>.
                                        </p>
                                        <p>
                                            Se solicita a las instituciones publicas, civiles, militares y policiales prestar la colaboracion necesaria.
                                        </p>
                                    </td>
                                </tr>
                                <tr style="transform: scaleX(-1)">
                                    <td class="align-center font-verdana-11">
                                        <div class="table-container-firma">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/firma-ejecutivo.jpg'))) }}" alt="#" class="logo-firma"/>
                                        </div>
                                        <br>
                                        <div class="table-container-qr">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/qr-gobierno-regional.jpg'))) }}" alt="#" class="logo-qr"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="transform: scaleX(-1)">
                                    <td>
                                        <div class="table-container-pie">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/pie-pagina-credencial.jpg'))) }}" alt="#" class="pie-pagina-credencial"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        @php
                            $i++
                        @endphp
                        @if (isset($empleados[$i]))
                            <td>
                                <table class="table-border-i-100">
                                    <tr style="transform: scaleX(-1)">
                                        <td class="table-container-pie">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/pie-pagina-credencial.jpg'))) }}" alt="#" class="pie-pagina-credencial"/>
                                        </td>
                                    </tr>
                                    <tr style="transform: scaleX(-1)">
                                        <td class="align-center font-verdana-11">
                                            <p>
                                                Al portador de este credencial se le indentifica como funcionario del <b>Gobierno Autonomo Regional del Gran Chaco</b>.
                                            </p>
                                            <p>
                                                Se solicita a las instituciones publicas, civiles, militares y policiales prestar la colaboracion necesaria.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="transform: scaleX(-1)">
                                        <td class="align-center font-verdana-11">
                                            <div class="table-container-firma">
                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/firma-ejecutivo.jpg'))) }}" alt="#" class="logo-firma"/>
                                            </div>
                                            <br>
                                            <div class="table-container-qr">
                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/qr-gobierno-regional.jpg'))) }}" alt="#" class="logo-qr"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="transform: scaleX(-1)">
                                        <td>
                                            <div class="table-container-pie">
                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/pie-pagina-credencial.jpg'))) }}" alt="#" class="pie-pagina-credencial"/>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        @endif
                        @php
                            $i++
                        @endphp
                        @if (isset($empleados[$i]))
                            <td>
                                <table class="table-border-i-100">
                                    <tr style="transform: scaleX(-1)">
                                        <td class="table-container-pie">
                                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/pie-pagina-credencial.jpg'))) }}" alt="#" class="pie-pagina-credencial"/>
                                        </td>
                                    </tr>
                                    <tr style="transform: scaleX(-1)">
                                        <td class="align-center font-verdana-11">
                                            <p>
                                                Al portador de este credencial se le indentifica como funcionario del <b>Gobierno Autonomo Regional del Gran Chaco</b>.
                                            </p>
                                            <p>
                                                Se solicita a las instituciones publicas, civiles, militares y policiales prestar la colaboracion necesaria.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="transform: scaleX(-1)">
                                        <td class="align-center font-verdana-11">
                                            <div class="table-container-firma">
                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/firma-ejecutivo.jpg'))) }}" alt="#" class="logo-firma"/>
                                            </div>
                                            <br>
                                            <div class="table-container-qr">
                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/qr-gobierno-regional.jpg'))) }}" alt="#" class="logo-qr"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="transform: scaleX(-1)">
                                        <td>
                                            <div class="table-container-pie">
                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos/pie-pagina-credencial.jpg'))) }}" alt="#" class="pie-pagina-credencial"/>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        @else
                            <td>
                                <table class="table-border-ielse-100">
                                    <tr>
                                        <td>
                                            <div class="table-container-empleado">
                                                &nbsp;
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        @endif
                        @php
                            $i++
                        @endphp
                    </tr>
                @endwhile
            @endif
        </table>
    </body>
</html>
