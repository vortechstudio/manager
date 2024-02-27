<?php

namespace App\Livewire\Social;

use Livewire\Attributes\Title;
use Livewire\Component;

class ArticleEdit extends Component
{
    #[Title("Edition d'un article")]
    public function render()
    {
        return view('livewire.social.article-edit')
            ->layout('layouts.app');
    }
}
