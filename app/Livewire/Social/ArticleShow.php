<?php

namespace App\Livewire\Social;

use App\Models\Social\Article;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

class ArticleShow extends Component
{
    use LivewireAlert;

    public Article $article;

    public function mount(int $id)
    {
        $this->article = Article::with('cercle', 'author')->find($id);
    }

    public function published(int $id)
    {
        if (Article::publish($id)) {
            $this->alert('success', 'Article publie avec succes');
        } else {
            $this->alert('error', 'Impossible de publier l\'article');
        }
    }

    public function unpublished(int $id)
    {
        if (Article::unpublish($id)) {
            $this->alert('success', 'Article dépublier');
        } else {
            $this->alert('error', 'Impossible de dépublier l\'article');
        }
    }

    #[Title('Gestion des articles')]
    public function render()
    {
        //dd($this->article->author()->first()->socials()->first());
        return view('livewire.social.article-show')
            ->layout('layouts.app');
    }
}
