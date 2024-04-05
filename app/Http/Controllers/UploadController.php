<?php

namespace App\Http\Controllers;

use App\Jobs\FormatImageJob;
use App\Jobs\UploadImageJob;
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
        dispatch(new UploadImageJob($request->file->getRealPath(), $request->type, $request->has('type_engine')));
    }
}
