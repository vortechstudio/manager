<?php

namespace App\Livewire\Social;

use App\Models\Social\Article;
use App\Services\Github\Issues;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Articles extends Component
{
    use LivewireAlert, WithPagination;

    public string $search = '';

    public string $orderField = 'title';

    public string $orderDirection = 'ASC';

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'title'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function setOrderField(string $name): void
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function published(int $id): void
    {
        if (Article::publish($id)) {
            $this->alert('success', 'Article publie avec succes');
        } else {
            $this->alert('error', 'Impossible de publier l\'article');
        }
    }

    public function unpublished(int $id): void
    {
        if (Article::unpublish($id)) {
            $this->alert('success', 'Article dépublier');
        } else {
            $this->alert('error', 'Impossible de dépublier l\'article');
        }
    }

    public function destroy(int $id): void
    {
        $article = Article::find($id);
        try {
            $article->delete();
            $this->alert('success', 'Article supprimé avec succes');
        } catch (\Exception $exception) {
            $issue = Issues::createIssueMonolog('article', "Impossible de supprimer l'article", [$exception], 'emergency');
            (new Issues($issue))->createIssueFromException();
            $this->alert('error', 'Impossible de supprimer l\'article');
        }

        try {
            \Storage::disk('vortech')->deleteDirectory('blog/'.$article->id);
        } catch (\Exception $exception) {
            $issue = Issues::createIssueMonolog('article', "Impossible de supprimer les images de l'article", [$exception], 'emergency');
            (new Issues($issue))->createIssueFromException();
            $this->alert('error', 'Impossible de supprimer les images de l\'article');
        }
    }

    #[Title('Gestion des Articles')]
    public function render()
    {
        return view('livewire.social.articles', [
            'articles' => Article::with('author', 'cercle')
                ->where('title', 'LIKE', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5),
        ])
            ->layout('layouts.app');
    }
}
