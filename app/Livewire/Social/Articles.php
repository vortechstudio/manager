<?php

namespace App\Livewire\Social;

use App\Models\Social\Article;
use App\Services\Github\Issues;
use Exception;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Articles extends Component
{
    use LivewireAlert, WithPagination;

    public Article|Collection|null $articles;

    public string $search = '';

    public string $orderField = 'title';

    public string $orderDirection = 'ASC';

    public string $title = '';

    public string $description = '';

    public string $contenue = '';

    public string $type = '';

    public int $cercle_id = 0;

    public int $author = 0;

    public bool $promote = false;

    public bool $published = false;

    public bool $publish_social = false;

    public string $published_at = '';

    public string $publish_social_at = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'title'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public function mount()
    {

    }

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

    public function save(): void
    {
        try {
            Article::create([
                'title' => $this->title,
                'description' => $this->description,
                'contenue' => $this->contenue,
                'type' => $this->type,
                'published' => false,
                'published_at' => null,
                'publish_social' => false,
                'publish_social_at' => null,
                'promote' => $this->promote,
                'status' => 'draft',
                'author' => $this->author,
                'cercle_id' => $this->cercle_id,
            ]);

            $this->alert('success', 'Article sauvegardé avec succes');
            $this->dispatch('closeModal', 'addArticle');
        } catch (Exception $exception) {
            \Log::critical($exception->getMessage(), $exception->getTrace());
            $this->alert('error', 'Impossible de sauvegarder l\'article');
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
        if (isset($this->articles)) {
            $articles = $this->articles->paginate(5);
        } else {
            $articles = Article::with('author', 'cercle')
                ->when($this->search, fn ($q) => $q->where('title', 'LIKE', "%{$this->search}%"))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5);
        }

        return view('livewire.social.articles', [
            'articles' => $articles,
        ])
            ->layout('layouts.app');
    }
}
