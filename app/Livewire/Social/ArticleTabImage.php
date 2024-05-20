<?php

namespace App\Livewire\Social;

use App\Jobs\FormatImageJob;
use App\Jobs\ResizeImageJob;
use App\Models\Social\Article;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticleTabImage extends Component
{
    use LivewireAlert, WithFileUploads;

    public Article $article;

    public $image;

    public function save(): void
    {
        try {
            $this->image->storeAs(
                'blog/'.$this->article->id,
                'default.'.$this->image->extension(),
                'vortech'
            );

            dispatch(new ResizeImageJob(
                filePath: \Storage::path('blog/'.$this->article->id.'/default.'.$this->image->getClientOriginalExtension()),
                directoryUpload: \Storage::path('blog/'.$this->article->id),
                sector: 'article'
            ));

            dispatch(new FormatImageJob(
                filePath: \Storage::path('blog/'.$this->article->id.'/default.'.$this->image->getClientOriginalExtension()),
                directoryUpload: \Storage::path('blog/'.$this->article->id),
                sector: 'article'
            ));

            $this->alert('success', 'Mise à jour des images effectuer avec succès. Veuillez patienter avant rafraichissement.');
        } catch (\Exception $exception) {
            \Log::critical($exception->getMessage(), [$exception]);
            $this->alert('error', $exception->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.social.article-tab-image');
    }
}
