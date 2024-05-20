<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UploadFile extends Component
{
    use LivewireAlert;

    public array $images = [];

    public bool $multiple = false;

    public Collection $model;

    public string $type = '';

    public function submit(): void
    {
        match ($this->type) {
            'rental' => $this->uploadRental($this->model, $this->images),
        };
    }

    public function render()
    {
        return view('livewire.upload-file');
    }

    private function uploadRental(Collection $model, array $images): void
    {
        $model->each(function ($model) use ($images) {
            \Storage::putFileAs('logos/rentals', $images[0], \Str::lower($model->name).'.webp');
        });

        $this->alert('success', 'Les images ont bien été téléchargées');
    }
}
