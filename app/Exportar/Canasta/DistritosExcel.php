<?php

namespace App\Exportar\Canasta;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class DistritosExcel implements FromView,ShouldAutoSize{
    use Exportable;

    public function __construct($distritos){
        $this->distritos = $distritos;
    }
    
    public function view(): view{
        $distritos = $this->distritos;
        return view('canasta_v2.distrito.excel',compact('distritos'));
    }
}