<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        'proveedores' => [
            'driver' => 'single',
            'path' => storage_path('logs/proveedores.log'),
            'level' => 'debug',
        ],

        'partidas' => [
            'driver' => 'single',
            'path' => storage_path('logs/partidas.log'),
            'level' => 'debug',
        ],

        'items' => [
            'driver' => 'single',
            'path' => storage_path('logs/items.log'),
            'level' => 'debug',
        ],

        'programas' => [
            'driver' => 'single',
            'path' => storage_path('logs/programas.log'),
            'level' => 'debug',
        ],

        'categorias_programaticas' => [
            'driver' => 'single',
            'path' => storage_path('logs/categorias_programaticas.log'),
            'level' => 'debug',
        ],

        'solicitudes_compras' => [
            'driver' => 'single',
            'path' => storage_path('logs/solicitudes_compras.log'),
            'level' => 'debug',
        ],

        'orden_compras' => [
            'driver' => 'single',
            'path' => storage_path('logs/orden_compras.log'),
            'level' => 'debug',
        ],

        'unidades' => [
            'driver' => 'single',
            'path' => storage_path('logs/unidades.log'),
            'level' => 'debug',
        ],

        'almacenes' => [
            'driver' => 'single',
            'path' => storage_path('logs/almacenes.log'),
            'level' => 'debug',
        ],

        'ingresos_almacen' => [
            'driver' => 'single',
            'path' => storage_path('logs/ingresos_almacen.log'),
            'level' => 'debug',
        ],

        'salidas_almacen' => [
            'driver' => 'single',
            'path' => storage_path('logs/salidas_almacen.log'),
            'level' => 'debug',
        ],

        'traspasos_almacen' => [
            'driver' => 'single',
            'path' => storage_path('logs/traspasos_almacen.log'),
            'level' => 'debug',
        ],

        'varios' => [
            'driver' => 'single',
            'path' => storage_path('logs/varios.log'),
            'level' => 'debug',
        ],

        'recursos_humanos' => [
            'driver' => 'single',
            'path' => storage_path('logs/recursos_humanos.log'),
            'level' => 'debug',
        ],

        'mantenimientos' => [
            'driver' => 'single',
            'path' => storage_path('logs/mantenimientos.log'),
            'level' => 'debug',
        ],

        'comandos' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'solicitud_materiales' => [
            'driver' => 'single',
            'path' => storage_path('logs/solicitud_materiales.log'),
            'level' => 'debug',
        ],
    ],

];
