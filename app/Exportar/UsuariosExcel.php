<?php

namespace App\Exportar;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class UsuariosExcel implements FromView,ShouldAutoSize{
    use Exportable;

    public function __construct($users){
        $this->users = $users;
    }
    
    public function view(): view{
        $users = $this->users;
        return view('admin.users.partials.excel',compact('users'));
    }
}