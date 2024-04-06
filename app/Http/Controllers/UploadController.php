<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'file' => 'required',
        ]);

        match ($request->type) {
            'engine' => $this->uploadEngine($request),
        };
    }

    private function uploadEngine(Request $request)
    {
        $request->file('file')->storeAs('uploads', $request->file('file')->getClientOriginalName());
    }
}
