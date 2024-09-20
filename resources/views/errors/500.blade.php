<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 - Server Error</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 1024px; margin: 0 auto; padding: 20px; }
        .error-message { color: red; }
        .error-trace {
            white-space: pre-wrap; /* Mantiene los saltos de línea y espacios, pero envuelve el texto */
            word-break: break-all; /* Permite que las palabras largas se rompan y se ajusten */
            background: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            overflow: auto;
            max-height: 400px; /* Añadir un máximo de altura para permitir el desplazamiento */
        }
        pre {
            margin: 0; /* Elimina el margen predeterminado del elemento <pre> */
            word-wrap: break-word; /* Asegura que las líneas largas se envuelvan */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Error 500 - Server Error</h1>
        <p>Something went wrong.</p>
        @if(isset($error))
            <div class="error-message">
                <h2>Error Message:</h2>
                <p>{{ $error }}</p>
            </div>
        @endif
        @if(isset($trace))
            <div class="error-trace">
                <h2>Error Trace:</h2>
                <pre>{{ $trace }}</pre>
            </div>
        @endif
    </div>
</body>
</html>

