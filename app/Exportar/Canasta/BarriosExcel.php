<?php

namespace App\Exportar\Canasta;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class BarriosExcel implements FromView,ShouldAutoSize{
    use Exportable;

    public function __construct($barrios){
        $this->barrios = $barrios;
    }
    
    public function view(): view{
        $barrios = $this->barrios;
        return view('canasta_v2.barrio.excel',compact('barrios'));
    }
}