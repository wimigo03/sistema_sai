<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;

class HomeController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function index()
    {
        //dd(auth()->user()->roles()->where('title', 'administrador')->toSql());

        //dd(auth()->user()->hasRole('superadmin'));
        return view('admin.home');
    }
}
