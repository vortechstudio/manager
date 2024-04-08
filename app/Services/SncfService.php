<?php

namespace App\Services;

use Illuminate\Support\Collection;

class SncfService
{
    public Collection $gare;
    public Collection $frequentation;

    public function __construct()
    {
        $this->gare = collect();

        foreach ($this->extractJsonFileGare() as $gare) {
            $this->gare->push([
                'name' => $gare['nom'],
                'latitude' => $gare['position_geographique']['lat'],
                'longitude' => $gare['position_geographique']['lon'],
                'city' => $gare['nom'],
                'pays' => 'France',
                'code_gare' => $gare['codes_uic'],
            ]);
        }

        $this->frequentation = collect();

        foreach ($this->extractJsonFileFreq() as $freq) {
            $this->frequentation->push([
                'name' => $freq['nom_gare'],
                'freq' => $freq['total_voyageurs_2022'],
            ]);
        }
    }

    public function searchGare($search)
    {
        $query = $this->gare->where('name', $search)
            ->first();
        if ($query === null) {
            return $this->gare->where('code_gare', $search)
                ->first();
        } else {
            return $query;
        }
    }

    public function searchFreq($search)
    {
        return $this->frequentation->where('name', $search)->first();
    }

    private function extractJsonFileGare()
    {
        $file = fopen(\Storage::path('data/gares-de-voyageurs.json'), 'r');
        $gares = json_decode(fread($file, filesize(\Storage::path('data/gares-de-voyageurs.json'))), true);
        fclose($file);

        return $gares;
    }

    private function extractJsonFileFreq()
    {
        $file = fopen(\Storage::path('data/frequentation-gares.json'), 'r');
        $gares = json_decode(fread($file, filesize(\Storage::path('data/frequentation-gares.json'))), true);
        fclose($file);

        return $gares;
    }
}
