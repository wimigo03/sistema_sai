<?php

namespace App\Exportar;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class RecepcionVentanillaExcel implements FromView,ShouldAutoSize{
    use Exportable;

    public function __construct($recepciones){
        $this->recepciones = $recepciones;
    }

    public function view(): view{
        $recepciones = $this->recepciones;
        $cont = 1;
        return view('correspondencia-local.excel',compact('recepciones', 'cont'));
    }
}
