<!DOCTYPE html>
<html>
<head>
    <title>Medidas</title>
</head>
<body>
    <h1>Medidas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>N INTERNA</th>
                <th>REFERENCIA</th>
                <th>DETALLE</th>
                <th>TIPO</th>
                <th>OFICINA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soluconsumos  as $item)
                <tr>
                    <td>{{ $item->idsoluconsumo }}</td>
                    <td>{{ $item->cominterna }}</td>
                    <td>{{ $item->referencia }}</td>
                    <td>{{ $item->detallesouconsumo }}</td>
                    <td>{{ $item->tipo }}</td>
                    <td>{{ $item->oficina }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
