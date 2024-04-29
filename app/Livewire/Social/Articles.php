<?php

namespace App\Livewire\Social;

use App\Jobs\FormatImageJob;
use App\Jobs\ResizeImageJob;
use App\Models\Social\Article;
use App\Services\Github\Issues;
use Carbon\Carbon;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Storage;

class Articles extends Component
{
    use LivewireAlert, WithFileUploads, WithPagination;

    public string $search = '';

    public string $orderField = 'title';

    public string $orderDirection = 'ASC';

    public string $title = '';

    public string $description = '';

    public string $contenue = '';

    public string $type = '';

    public $image = null;

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

    public function save()
    {
        $this->validate([
            'title' => 'required|string|min:5',
            'description' => 'max:255',
            'contenue' => 'required',
            'author' => 'required',
            'cercle_id' => 'required',
            'type' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        try {
            $article = Article::create([
                'title' => $this->title,
                'description' => $this->description,
                'contenue' => $this->contenue,
                'type' => $this->type,
                'published' => $this->published,
                'published_at' => $this->published_at != '' ? Carbon::createFromTimestamp(strtotime($this->published_at)) : null,
                'publish_social' => $this->publish_social,
                'publish_social_at' => $this->publish_social_at != '' ? Carbon::createFromTimestamp(strtotime($this->publish_social_at)) : null,
                'promote' => $this->promote,
                'status' => 'draft',
                'author' => $this->author,
                'cercle_id' => $this->cercle_id,
            ]);
        } catch (Exception $exception) {
            \Log::critical($exception->getMessage(), $exception->getTrace());
            $this->alert('error', 'Impossible de sauvegarder l\'article');
        }

        try {
            // On enregistre l'image dans le dossier blog et on déclenche un job permettant de structurer les images pour un header
            $this->image->storeAs(
                'blog/'.$article->id,
                'default.'.$this->image->extension(),
                'vortech'
            );

            dispatch(new ResizeImageJob(
                filePath: Storage::disk('vortech')->path('blog/'.$article->id.'/default.'.$this->image->getClientOriginalExtension()),
                directoryUpload: Storage::disk('vortech')->path('blog/'.$article->id),
                sector: 'article'
            ));

            dispatch(new FormatImageJob(
                filePath: Storage::disk('vortech')->path('blog/'.$article->id.'/default.'.$this->image->getClientOriginalExtension()),
                directoryUpload: Storage::disk('vortech')->path('blog/'.$article->id),
                sector: 'article'
            ));

            Storage::disk('vortech')->delete('blog/'.$article->id.'/default.'.$this->image->getClientOriginalExtension());
        } catch (Exception $exception) {
            \Log::critical($exception->getMessage(), $exception->getTrace());
            $issue = new Issues(Issues::createIssueMonolog('article_image', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException();
            toastr()->addError($exception->getMessage());
        }

        $this->alert('success', 'Article sauvegardé avec succes');
        $this->dispatch('closeModal', 'addArticle');
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
                ->when($this->search, fn ($q) => $q->where('title', 'LIKE', "%{$this->search}%"))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5),
        ])
            ->layout('layouts.app');
    }
}
