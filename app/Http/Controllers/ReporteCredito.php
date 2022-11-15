<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteCredito extends Controller
{
    public function index()
    {
        return view('admin.reportecredito.index');
    }
}
