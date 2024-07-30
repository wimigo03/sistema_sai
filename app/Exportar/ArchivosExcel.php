<?php

namespace App\Exportar;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class ArchivosExcel implements FromView,ShouldAutoSize{
    use Exportable;

    public function __construct($archivos, $cont){
        $this->archivos = $archivos;
        $this->cont = $cont;
    }

    public function view(): view{
        $archivos = $this->archivos;
        $cont = $this->cont;
        return view('archivos.excel',compact('archivos', 'cont'));
    }
}
