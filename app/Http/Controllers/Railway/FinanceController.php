<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Config\RailwayBanque;

class FinanceController extends Controller
{
    public function index()
    {
        return view('railway.finance.index');
    }

    public function show(RailwayBanque $banque)
    {
        return view('railway.finance.show', compact('banque'));
    }
}
