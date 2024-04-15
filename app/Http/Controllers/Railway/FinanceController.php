<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    public function index()
    {
        return view('railway.finance.index');
    }
}
