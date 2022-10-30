<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteJornada extends Controller
{
    public function index()
    {
        return view('admin.reportejornada.index');
    }
}
