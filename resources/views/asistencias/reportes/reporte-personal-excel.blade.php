<!DOCTYPE html>
<html lang="en">

<body>
    <style>
        table {
            display: inline-block;
            margin-right: 20px;
            /* Adjust the spacing between tables as needed */
            vertical-align: top;
            /* Align tables at the top */
        }

        p {
            margin: 0;
            padding: 5px;
        }

        /* Add any additional styling as needed */
    </style>
    <table>
        <tr>
            <td>
                <b>Fecha Descarga: </b>
                {{ date("d-m-Y H:i") }} 
            </td>

            <td>
                <b>Usuario: </b>
                 {{ Auth()->user()->name }}


            </td>

            <td>
              </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>
            </td>

            <td>
            </td>

            <td>
            </td>
        </tr>
        <tr>
            <td>
                <b>Desde: </b>
                {{ $fechaInicio }}
            </td>

            <td>
                <b>Hasta: </b>
                {{ $fechaFinal }}



            </td>

            <td>
                <b>Unidad: </b>
                {{ $empleadoDatos->empleadosareas->nombrearea }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>
                <p>Nombres: </p>
                <p> {{ $empleadoDatos->nombres }}</p>

            </td>

            <td>
                <p> Apellidos:</p>
                <p> {{ $empleadoDatos->ap_pat }} {{ $empleadoDatos->ap_mat }}</p>

            </td>

            <td>
                <p>CI: </p>
                <p> {{ $empleadoDatos->ci }}</p>

            </td>

        </tr>
        <tr>


        </tr>
    </table>

    <table>
        <tr>
            <td>
                <b>Nombres y Apellidos</b>
            </td>
            <td>
                <b>Minutos de Retraso</b>
            </td>
            <td>
                <b>Descuento Según Haber Básico</b>
            </td>
        </tr>
        @foreach ($data['data'] as $empleado)
        <tr>
            <td>
                <p>{{ $empleado['empleado'] }}</p>
            </td>
            <td>
                <p>{{ $empleado['total_retrasos'] }}</p>
            </td>
            <td>
                <p>{{ $empleado['observaciones'] }}</p>
            </td>
        </tr>
        @endforeach
    </table>


</body>

</html>