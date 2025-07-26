<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }
}
