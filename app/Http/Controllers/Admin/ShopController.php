<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function __invoke()
    {
        return view('admin.shop.index');
    }
}
