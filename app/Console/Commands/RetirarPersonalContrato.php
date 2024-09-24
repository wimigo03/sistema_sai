<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RetirarPersonalContrato extends Command
{
    protected $signature = 'tarea:retirar-personal-contrato';
    protected $description = 'Retirar personal que ya vencio su contrato';

    public function __construct()
    {
        parent::__construct();
    }

    // Lógica del comando
    public function handle()
    {
        // Aquí va la tarea que deseas ejecutar
        \Log::info('El comando cron personalizado ha sido ejecutado.');
        $this->info('Comando ejecutado correctamente.');
    }
}
