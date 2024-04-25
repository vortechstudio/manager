<?php

namespace App\Http\Controllers;

use App\Jobs\FormatImageJob;
use App\Models\Railway\Config\RailwayRental;
use Exception;
use Illuminate\Http\Request;
use Storage;

class UploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'file' => 'required|image|max:2048',
        ]);

        return match ($request->type) {
            'engine' => $this->uploadEngine($request),
            'rental' => $this->uploadRental($request),
            'banque' => $this->uploadBanque($request),
            default => abort(404, 'Type inconnu'),
        };
    }

    private function uploadEngine(Request $request)
    {
        $request->file('file')->storeAs('uploads', $request->file('file')->getClientOriginalName());

        return redirect()->back();
    }

    private function uploadRental(Request $request)
    {
        //dd($request->file('file'));
        $rental = RailwayRental::find($request->get('model'));
        try {
            $request->file->storeAs(
                'logos/rentals',
                \Str::lower($rental->name).'.'.$request->file('file')->extension(),
            );

            dispatch(new FormatImageJob(
                \Storage::path('logos/rentals/'.\Str::lower($rental->name).'.'.$request->file('file')->getClientOriginalExtension()),
                directoryUpload: Storage::path('logos/rentals'),
                sector: 'rental',
                nameFile: \Str::lower($rental->name),
            ));

            Storage::delete('logos/rentals/'.\Str::lower($rental->name).'.'.$request->file('file')->getClientOriginalExtension());

            toastr()->addSuccess("L'image a été créée");
        } catch (Exception $exception) {
            toastr()->addError($exception->getMessage());
        }

        return redirect()->back();
    }

    private function uploadBanque(Request $request)
    {
        $banque = RailwayBanque::find($request->get('model'));
        try {
            $request->file->storeAs(
                'logos/banks',
                \Str::lower($banque->name).'.'.$request->file('file')->extension(),
            );

            dispatch(new FormatImageJob(
                \Storage::path('logos/banks/'.\Str::lower($banque->name).'.'.$request->file('file')->getClientOriginalExtension()),
                directoryUpload: Storage::path('logos/banks'),
                sector: 'banque',
                nameFile: \Str::lower($banque->name),
            ));

            Storage::delete('logos/banks/'.\Str::lower($banque->name).'.'.$request->file('file')->getClientOriginalExtension());

            toastr()->addSuccess("L'image a été crée");
        } catch (Exception $exception) {
            toastr()->addError($exception->getMessage());
        }

        return redirect()->back();
    }
}
