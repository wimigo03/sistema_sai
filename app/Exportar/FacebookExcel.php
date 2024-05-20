<?php

namespace App\Exportar;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class FacebookExcel implements FromView{
    use Exportable;

    public function __construct($facebook,$facebook_detalles,$count_shares,$count_likes,$count_comments,$cont){
        $this->facebook = $facebook;
        $this->facebook_detalles = $facebook_detalles;
        $this->count_shares = $count_shares;
        $this->count_likes = $count_likes;
        $this->count_comments = $count_comments;
        $this->cont = $cont;
    }

    public function view(): view{
        $facebook = $this->facebook;
        $facebook_detalles = $this->facebook_detalles;
        $count_shares = $this->count_shares;
        $count_likes = $this->count_likes;
        $count_comments = $this->count_comments;
        $cont = $this->cont;
        return view('facebook.excel',compact('facebook','facebook_detalles','count_shares','count_likes','count_comments','cont'));
    }
}
