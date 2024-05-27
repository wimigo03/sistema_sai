<?php

namespace App\Exportar\Canasta;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class BeneficiariosExcel implements FromView,ShouldAutoSize{
    use Exportable;

    public function __construct($beneficiarios){
        $this->beneficiarios = $beneficiarios;
    }

    public function view(): view{
        $beneficiarios = $this->beneficiarios;
        return view('canasta_v2.beneficiario.excel',compact('beneficiarios'));
    }
}
