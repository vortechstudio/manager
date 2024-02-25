<?php

namespace App\Livewire\Social;

use App\Models\Social\Article;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Articles extends Component
{
    use WithPagination, LivewireAlert;
    public string $search = '';
    public string $orderField = 'title';
    public string $orderDirection = 'ASC';

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'title'],
        'orderDirection' => ['except' => 'ASC']
    ];

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function setOrderField(string $name) {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }


    #[Title("Gestion des Articles")]
    public function render()
    {
        return view('livewire.social.articles', [
            "articles" => Article::with('author', 'cercle')
                ->where('title', 'LIKE', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ])
            ->layout('layouts.app');
    }
}
