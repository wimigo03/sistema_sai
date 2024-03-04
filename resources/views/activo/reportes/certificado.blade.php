<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>CERTIFICADO DE NO ADEUDO</title>
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: sans-serif;
        }

        body {
            margin-top: 1cm;
            margin-left: 2.5cm;
            margin-right: 2.5cm;
            margin-bottom: 1cm;
        }

        .mr-3 {
            margin-right: 1.5rem;
        }

        .ml-3 {
            margin-left: 1.5rem !important;
        }

        footer {
            position: fixed;
            bottom: 1cm;
            left: 2.5cm;
            right: 2.5cm;
            height: 150px;
            font-size: 13px;
        }

        .font-size {
            font-size: 13px
        }

        .font-justify {
            text-align: justify;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;">
            <tr>
                <td style="width: 33%; text-align: left;">
                    <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/logoizquierda.png'))) }}"
                        width="170px" alt="Imagen">
                </td>
                <td style="width: 33%; text-align: center;">
                    <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/activos-fijos.png'))) }}"
                        width="130px" alt="Imagen">
                </td>
                <td style="width: 33%; text-align: right;">
                    <img width="110px"
                        src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/logoderecha2.png'))) }}"
                        alt="Imagen">
                </td>
            </tr>
        </table>
    </header>
    <footer>
        <table width="100%">
            <tr>
                <td style="width: 33.33%; text-align: center;">
                    Elaborado por
                    <br>
                    <span style="color: rgb(158, 158, 158)">Firma y sello</span>
                </td>
                <td style="width: 33.33%; text-align: center;">
                    Jefe de Unidad
                    <br>
                    <span style="color: rgb(158, 158, 158)">Firma y sello</span>
                </td>
                <td style="width: 33.33%; text-align: center;">
                    Solicitante
                    <br>
                    <span style="color: rgb(158, 158, 158)">Firma y sello</span>
                </td>
            </tr>
        </table>
        <table style="padding-top: 1cm">
            <tr>
                <td style="width: 100%">
                    <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('/logos/piedepagina.png'))) }}"
                        width="100%" alt="Imagen">
                </td>
            </tr>
        </table>

    </footer>
    <main>
        <table style="width: 100%">
            <tr>
                <td style="width: 100%; text-align: right; margin-bottom: 0px; color:red;">
                    <b>N°:{{ str_pad($adeudo->id, 3, '0', STR_PAD_LEFT) }}</b>
                </td>
            </tr>
            <tr>
                <td style="text-align: center">
                    <h1 style="margin-bottom: 4px; margin-top: 0px;">CERTIFICADO DE NO ADEUDO</h1>
                    <span class="font-size">LA UNIDAD REGIONAL DE ACTIVOS FIJOS DEL GOBIERNO AUTÓNOMO REGIONAL
                        GRAN CHACO QUE AL FINAL SUSCRIBE</span>
                    <h1>CERTIFICA</h1>
                </td>
            </tr>
            <tr>
                <td class="font-justify font-size">
                    QUE EL SEÑOR <b> {{ $responsable->nombres }} {{ $responsable->ap_pat }} {{ $responsable->ap_mat }}
                    </b> DE NACIONALIDAD BOLIVIANA CON NUMERO DE CEDULA DE IDENTIDAD:
                    <b>{{ $responsable->ci }}</b> Y NUMERO DE CONTRATO O ASIGNACIÓN
                    <b>{{ $responsable->adeudo->nro_contrato }}/{{ date('Y')}} </b> HA DESEMPEÑADO FUNCIONES DE <b>
                        {{ $responsable->file->nombrecargo }} </b>
                    CON FECHA DE INICIO <b>{{ $fecha_inicio }}</b> Y FECHA DE CONCLUSION
                    <b>{{ $fecha_fin }}</b> EN LA ENTIDAD
                    <br>
                    <br>
                    DESPUES DE HABER CUMPLIDO CON EL ARTÍCULO 148 DEL D.S. 0181 DE LAS NORMAS BÁSICAS DEL SISTEMA DE
                    ADMINISTRACIÓN DE BIENES Y SERVICIOS, REGLAMENTO INTERNO DE ACTIVOS Y PROCEDIMIENTOS
                    ADMINISTRATIVOS DE DEVOLUCIÓN DE ACTIVOS A LA ENTIDAD.
                    <br>
                    <br>
                    A PETICIÓN DEL SOLICITANTE SE EXTIENDE EL PRESENTE PARA LOS FINES QUE ESTIME CONVENIENTE
                    <br>
                    YACUIB, <b> {{ $fecha_hoy }} </b>
                </td>
            </tr>
        </table>
    </main>
</body>

</html>
