<?php

namespace App\Livewire\Social;

use App\Jobs\FormatImageJob;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CercleImage extends Component
{
    use LivewireAlert, WithFileUploads;

    public \App\Models\Social\Cercle $cercle;

    public $header;

    public $default;

    public $icon;

    public function save()
    {
        try {
            $this->header->storeAs(
                'cercles/'.$this->cercle->id,
                'header.'.$this->header->extension(),
                'vortech'
            );

            $this->default->storeAs(
                'cercles/'.$this->cercle->id,
                'default.'.$this->default->extension(),
                'vortech'
            );

            $this->icon->storeAs(
                'cercles/'.$this->cercle->id,
                'icon.'.$this->icon->extension(),
                'vortech'
            );

            dispatch(new FormatImageJob(
                filePath: \Storage::path('cercles/'.$this->cercle->id.'/header.'.$this->header->getClientOriginalExtension()),
                directoryUpload: \Storage::path('cercles/'.$this->cercle->id),
                sector: 'cercle_header'
            ));

            dispatch(new FormatImageJob(
                filePath: \Storage::path('cercles/'.$this->cercle->id.'/default.'.$this->default->getClientOriginalExtension()),
                directoryUpload: \Storage::path('cercles/'.$this->cercle->id),
                sector: 'cercle'
            ));

            dispatch(new FormatImageJob(
                filePath: \Storage::path('cercles/'.$this->cercle->id.'/icon.'.$this->icon->getClientOriginalExtension()),
                directoryUpload: \Storage::path('cercles/'.$this->cercle->id),
                sector: 'cercle_icon'
            ));

            $this->alert('success', 'Image modifier avec succès');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors de l'upload de l'image");
        }
    }

    public function render()
    {
        return view('livewire.social.cercle-image');
    }
}
