<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta name="generator" content="Aspose.Words for .NET 23.12.0" />
    <title></title>

</head>

<body>
    <table border="0" cellspacing="0" cellpadding="0" width="0">
        <tbody>
            <tr>
                <td width="671" colspan="2" valign="top" bgcolor= "#DDDDDD">
                    <p align="center">
                        <strong>DETALLE    DEL BENEFICIARIO</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Cedula:</strong>
                    </p>
                </td>
                <td width="302" valign="top" bgcolor= "#E1FFFF" align="center">
                    <p>
                        <strong>Foto</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->ci }}
                    </p>
                </td>
                <td width="302" rowspan="23" valign="top" align="center">
                </br></br></br></br>
                        <img src="{{ asset(substr($beneficiario->dir_foto, 2)) }}" width="200" >

                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Nombres:</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->nombres }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Apellido Paterno:</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->ap }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Apellido Materno:</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->am }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Fecha de Nacimiento:</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->fecha_nac }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Estado Civil</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->estado_civil }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Genero:</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->sexo }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Ocupación:</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->ocupacion->ocupacion }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Barrio/Comunidad</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->barrio->nombre  }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Dirección:</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->direccion }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Firma:</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top">
                    <p>
                        {{ $beneficiario->firma }}
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        <strong>Observación:</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="369" valign="top" bgcolor= "#E1FFFF">
                    <p>
                        {{ $beneficiario->obs }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
