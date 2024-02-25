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

    public function setOrderField(string $name)
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function published(int $id)
    {
        $article = Article::find($id);
        try {
            $article->update([
                'published' => true,
                'publish_social' => true,
                'published_at' => now(),
                'publish_social_at' => now(),
                'status' => 'published',
            ]);
            $this->alert('success', 'Article publie avec succes');
        } catch (\Exception $exception) {
            $issue = Issues::createIssueMonolog('article', "Impossible de publier l'article", [$exception], 'emergency');
            (new Issues($issue))->createIssueFromException(false);
            $this->alert('error', 'Impossible de publier l\'article');
        }
    }

    public function unpublished(int $id)
    {
        $article = Article::find($id);

        try {
            $article->update([
                'published' => false,
                'publish_social' => false,
                'published_at' => null,
                'publish_social_at' => null,
                'status' => 'draft',
            ]);
            $this->alert('success', 'Article dépublie avec succes');
        } catch (\Exception $exception) {
            $issue = Issues::createIssueMonolog('article', "Impossible de dépublier l'article", [$exception], 'emergency');
            (new Issues($issue))->createIssueFromException(false);
            $this->alert('error', 'Impossible de dépublier l\'article');
        }
    }

    public function destroy(int $id)
    {
        $article = Article::find($id);
        try {
            $article->delete();
            $this->alert('success', 'Article supprimé avec succes');
        } catch (\Exception $exception) {
            $issue = Issues::createIssueMonolog('article', "Impossible de supprimer l'article", [$exception], 'emergency');
            (new Issues($issue))->createIssueFromException(false);
            $this->alert('error', 'Impossible de supprimer l\'article');
        }

        try {
            \Storage::disk('vortech')->deleteDirectory('blog/'.$article->id);
        } catch (\Exception $exception) {
            $issue = Issues::createIssueMonolog('article', "Impossible de supprimer les images de l'article", [$exception], 'emergency');
            (new Issues($issue))->createIssueFromException(false);
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
