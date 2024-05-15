<?php

namespace App\Exportar;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class EmpleadosExcel implements FromView,ShouldAutoSize{
    use Exportable;

    public function __construct($empleados){
        $this->empleados = $empleados;
    }

    public function view(): view{
        $empleados = $this->empleados;
        return view('empleados.excel',compact('empleados'));
    }
}
