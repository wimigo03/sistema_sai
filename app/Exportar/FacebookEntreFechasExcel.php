<?php

namespace App\Exportar;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class FacebookEntreFechasExcel implements FromView{
    use Exportable;

    public function __construct($fecha_i,$fecha_f,$empleados,$cont){
        $this->fecha_i = $fecha_i;
        $this->fecha_f = $fecha_f;
        $this->empleados = $empleados;
        $this->cont = $cont;
    }

    public function view(): view{
        $fecha_i = $this->fecha_i;
        $fecha_f = $this->fecha_f;
        $empleados = $this->empleados;
        $cont = $this->cont;
        return view('facebook.excel-entre-fechas',compact('fecha_i','fecha_f','empleados','cont'));
    }
}
