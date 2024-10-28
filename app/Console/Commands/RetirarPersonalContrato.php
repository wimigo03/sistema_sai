<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Models\Empleado;
use App\Models\EmpleadoContrato;
use App\Models\User;

class RetirarPersonalContrato extends Command
{
    protected $signature = 'tarea:retirar-personal-contrato';
    protected $description = 'Retirar personal que ya vencio su contrato';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $contratos = EmpleadoContrato::where('tipo','2')
                                            ->where('estado','1')
                                            ->where('fecha_conclusion_contrato','!=',null)
                                            ->get();
            $cont = 0;
            foreach($contratos as $contrato){
                if(date('Y-m-d') > $contrato->fecha_conclusion_contrato){
                    $contrato = EmpleadoContrato::find($contrato->id);
                    $contrato->update([
                        'fecha_retiro' => date('Y-m-d'),
                        'estado' => '2',
                        'user_id' => 102,
                        'obs_retiro' => 'PROCESO DE RETIRO AUTOMATICO'
                    ]);
                }

                $_contratos = EmpleadoContrato::where('idemp',$contrato->idemp)
                                                ->where('tipo','2')
                                                ->where('estado','1')
                                                ->get()
                                                ->count();
                if($_contratos == 0){
                    $cont = $cont++;
                    $_empleado = Empleado::find($contrato->idemp);
                    $_empleado->update([
                        'estado' => '2'
                    ]);

                    $users = User::where('idemp',$contrato->idemp)->get();
                    if($users != null){
                        foreach($users as $user){
                            $_user = User::find($user->id);
                            $user->update([
                                'estadouser' => 0
                            ]);
                        }
                    }
                }
            }

            \Log::info($cont . ' Empleados dados de baja. El comando RETIRAR PERSONAL CONTRATO se ejecuto correctamente.');
            $this->info('Comando ejecutado correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error al ejecutar el comando RETIRAR PERSONAL CONTRATO: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            $this->error('Hubo un error al ejecutar el comando.');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
