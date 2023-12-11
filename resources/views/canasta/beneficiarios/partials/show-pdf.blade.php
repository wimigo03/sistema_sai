<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Detalle de beneficiario</title>
	<style>
		body {
			font-family: verdana,arial,helvetica;
			font-size: 9px;
		}
        .table-titulo {
			width: 100%;
			border-collapse: collapse;
		}
		.table-header {
			width: 100%;
		}
        .table-header td {
            padding: 3px;
			border-collapse: collapse;
		}
		.table-data {
			width: 100%;
			border-collapse: collapse;
			border-bottom: 1px solid #000000;
			border-top: 1px solid #000000;
		}
        .table-data td {
			padding: 5px;
			border-bottom: 1px solid #000000;
		}
	</style>
</head>
<body>
	<table class="table-titulo">
		<tr>
			<td align="center">
				<h2>DATOS DEL BENEFICIARIO</h2>
			</td>
		</tr>
	</table>
    <table class="table-header">
		<tr>
			<td>
                <b>NOMBRE COMPLETO: </b>{{ $beneficiario->nombre_completo }}
            </td>
            <td>
                <b>NRO. DE CARNET: </b>{{ $beneficiario->ci . '-' . $beneficiario->expedido }}
            </td>
            <td>
                <b>NATALICIO: </b>{{ \Carbon\Carbon::parse($beneficiario->fechaNac)->format('d/m/Y') }}
            </td>
		</tr>
        <tr>
            <td>
                <b>ESTADO CIVIL: </b>{{ strtoupper($beneficiario->estadoCivil) }}
            </td>
            <td>
                <b>SEXO: </b>{{ $beneficiario->sexo }}
            </td>
            <td>
                &nbsp;
            </td>
		</tr>
        <tr>
            <td colspan="3">
                <b>DIRECCION: </b>{{ strtoupper($beneficiario->direccion) }}
            </td>
        </tr>
        <tr>
            <td>
                <b>FIRMA: </b>{{ $beneficiario->firma }}
            </td>
            <td>
                <b>ESTADO: </b>{{ $beneficiario->estado }}
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>BARRIO: </b>{{ $beneficiario->barrios != null ? strtoupper($beneficiario->barrios->barrio) : '#' }}
            </td>
            <td>
                <b>OCUPACION: </b>{{ $beneficiario->ocupacion->ocupacion }}
            </td>
        </tr>
        <tr>
            <td>
                <b>F. REGISTRO: </b>{{ \Carbon\Carbon::parse($beneficiario->registrado)->format('d/m/Y') }}
            </td>
            <td colspan="2">
                <b>USUARIO: </b>{{ $beneficiario->admin != null ? $beneficiario->admin->nombre_completo : '#' }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>OBSERVACIONES: </b>{{ strtoupper($beneficiario->obs) }}
            </td>
        </tr>
	</table>
    @if (isset($historial_bajas) && count($historial_bajas) > 0)
        <table class="table-header">
            <tr>
                <td align="center">
                    <b><u>BAJAS</u></b>
                </td>
            </tr>
        </table>
        <table class="table-data">
            <tr>
                <td><b>CODIGO</b></td>
                <td><b>IP</b></td>
                <td align="center"><b>FECHA</b></td>
                <td><b>OBSERVACIONES</b></td>
                <td align="center"><b>ESTADO</b></td>
                <td><b>USUARIO</b></td>
            </tr>
            @foreach ($historial_bajas as $datos)
                <tr>
                    <td>{{ $datos->idHistorialBaja }}</td>
                    <td>{{ $datos->ip }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $datos->obs }}</td>
                    <td align="center">{{ $datos->estado }}</td>
                    <td>{{ $datos->admin->nombre_completo }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    @if (isset($historial_mod) && count($historial_mod) > 0)
        <br>
        <table class="table-header">
            <tr>
                <td align="center">
                    <b><u>MODIFICACIONES</u></b>
                </td>
            </tr>
        </table>
        <table class="table-data">
            <tr>
                <td><b>CODIGO</b></td>
                <td><b>IP</b></td>
                <td align="center"><b>FECHA</b></td>
                <td><b>OBSERVACIONES</b></td>
                <td align="center"><b>ESTADO</b></td>
                <td><b>USUARIO</b></td>
            </tr>
            @foreach ($historial_mod as $datos)
                <tr>
                    <td>{{ $datos->idHistorialMod }}</td>
                    <td>{{ $datos->ip }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                    <td>{{ strtoupper($datos->observacion) }}</td>
                    <td align="center">{{ $datos->estado }}</td>
                    <td>{{ $datos->admin->nombre_completo }}</td>
                </tr>
            @endforeach
        </table>
    @endif	
</body>
</html>