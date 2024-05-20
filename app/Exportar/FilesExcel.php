<?php

namespace App\Exportar;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class FilesExcel implements FromView,ShouldAutoSize{

    use Exportable;

    public function __construct($files){
        $this->files = $files;
    }

    public function view(): view{
        $files = $this->files;
        return view('files.excel',compact('files'));
    }
}
