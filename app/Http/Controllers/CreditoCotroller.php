<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditoCotroller extends Controller
{
    //
    public function index()
    {
        return view('admin.creditos.index');
    }
}
