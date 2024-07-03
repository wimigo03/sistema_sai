<?php

namespace App\Exportar\Canasta;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class PaquetesBarrioExcel implements FromView,ShouldAutoSize{
    use Exportable;

    public function __construct($paquete,$paquetes_barrios,$cont){
        $this->paquete = $paquete;
        $this->paquetes_barrios = $paquetes_barrios;
        $this->cont = $cont;
    }

    public function view(): view{
        $paquete = $this->paquete;
        $paquetes_barrios = $this->paquetes_barrios;
        $cont = $this->cont;
        return view('canasta_v2.paquetes-barrio.excel',compact('paquete','paquetes_barrios','cont'));
    }
}
