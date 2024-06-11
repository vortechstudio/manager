<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Research\RailwayResearchCategory;

class ResearchController extends Controller
{
    public function index()
    {
        return view('railway.research.index');
    }

    public function category(int $category_id)
    {
        $category = RailwayResearchCategory::with('railwayResearches')->find($category_id);
        return view('railway.research.category', [
            "category" => $category
        ]);
    }
}
