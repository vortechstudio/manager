<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Core\ShopCategory;

class ShopController extends Controller
{
    public function index()
    {
        return view('railway.shop.index');
    }

    public function category(int $category_id)
    {
        $category = ShopCategory::with('items', 'packages')->find($category_id);
        return view('railway.shop.category', ['category' => $category]);
    }
}
