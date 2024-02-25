<?php

namespace App\Livewire\Social;

use App\Models\Social\Article;
use Livewire\Attributes\Title;
use Livewire\Component;

class ArticleShow extends Component
{
    public Article $article;

    public function mount(int $id)
    {
        $this->article = Article::with('cercle', 'author')->find($id);
    }
    #[Title("Gestion des articles")]
    public function render()
    {
        //dd($this->article->author()->first()->socials()->first());
        return view('livewire.social.article-show')
            ->layout('layouts.app');
    }
}
