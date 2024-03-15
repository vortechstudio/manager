<?php

namespace App\Livewire\Social;

use App\Livewire\Table\Column;
use App\Livewire\Table\Table;
use App\Models\Social\Article;

class ArticleTable extends Table
{
    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return Article::query();
    }

    public function columns(): array
    {
        return [
            Column::make('id', '#'),
            Column::make('title', 'Titre'),
            Column::make('cercle_id', 'Cercle'),
            Column::make('author', 'Auteur'),
            Column::make('updated_at', 'Date'),
        ];
    }
}
