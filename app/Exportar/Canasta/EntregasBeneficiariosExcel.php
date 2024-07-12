<?php

namespace App\Exportar\Canasta;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class EntregasBeneficiariosExcel implements FromView,ShouldAutoSize{
    use Exportable;

    public function __construct($paquete_barrio,$entregas,$cont){
        $this->paquete_barrio = $paquete_barrio;
        $this->entregas = $entregas;
        $this->cont = $cont;
    }

    public function view(): view{
        $paquete_barrio = $this->paquete_barrio;
        $entregas = $this->entregas;
        $cont = $this->cont;
        return view('canasta_v2.paquetes.beneficiarios-excel',compact('paquete_barrio','entregas','cont'));
    }
}
