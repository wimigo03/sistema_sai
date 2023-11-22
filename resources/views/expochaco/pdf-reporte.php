<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REPORTE</title>
    <style>
        html{
            margin: 94.49px 94.49px 94.49px 94.49px;
            /*font-size: 1em;*/
            font-size: 14px;
            /*font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";*/
            font-family: Serif;
            /*line-height: 2.0;*/
            /*background-color: #ffffff;*/
        }
        table,tr,td{
            border-collapse: collapse;
        }
        .table-border{
            border-collapse: collapse;
            border: 0.5px solid
        }
    </style>
</head>
<body>
<table width="100%" class="table-border" cellpadding="2">
                    <tr class="table-border">
                        <td align="center" class="table-border"><b>N°</b></td>
                        <td align="center" class="table-border"><b>NOMBRES</b></td>
                        <td align="center" class="table-border"><b>CI</b></td>
                        <td align="center" class="table-border"><b>STAND</b></td>
                    </tr>
                    @php
                        $num = 1;
                    @endphp
                    @if (count($credenciales) > 0)
                        @foreach ($credenciales as $credencial)
                            <tr class="table-border">
                                <td align="left" class="table-border">{{$num++}}</td>
                                <td align="left" class="table-border">{{$credencial->nombres}}</td>
                                <td align="left" class="table-border">{{$credencial->ci}}</td>
                                <td align="center" class="table-border">{{$credencial->stand}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>

</body>
</html>
