<?php

namespace App\Livewire\Social;

use App\Models\User\User;
use App\Services\Github\Issues;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Pharaonic\Laravel\Pages\Models\Page;

class Pages extends Component
{
    use LivewireAlert, WithPagination;

    public string $search = '';

    public string $orderField = 'id';

    public string $orderDirection = 'ASC';

    public string $title = '';

    public string $description = '';

    public string $content = '';

    public string $keywords = '';

    public int $author = 0;

    public bool $published = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'id'],
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

    public function render()
    {
        $pages = Page::with('translations', 'creator')
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate(10);

        return view('livewire.social.pages', [
            'pages' => $pages,
        ]);
    }

    public function destroy(int $id): void
    {
        try {
            $page = Page::findOrFail($id);
            $page->delete();
        } catch (\Exception $exception) {
            $issue = new Issues(Issues::createIssueMonolog('page', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException();
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function published(int $id): void
    {
        try {
            $page = Page::findOrFail($id);
            $page->published = true;
            $page->save();
        } catch (\Exception $exception) {
            $issue = new Issues(Issues::createIssueMonolog('page', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException();
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function unpublished(int $id): void
    {
        try {
            $page = Page::findOrFail($id);
            $page->published = false;
            $page->save();
        } catch (\Exception $exception) {
            $issue = new Issues(Issues::createIssueMonolog('page', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException();
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
        ]);

        try {
            $page = Page::create([
                'published' => $this->published,
            ]);

            $page->translateOrNew('fr')->title = $this->title;
            $page->translateOrNew('fr')->description = $this->description;
            $page->translateOrNew('fr')->content = $this->content;
            $page->translateOrNew('fr')->keywords = $this->keywords;

            $page->creator_id = $this->author;
            $page->creator_type = User::class;

            $page->save();

            $this->alert('success', 'La page a bien été enregistrée');
            $this->dispatch('closeModal', 'addPage');
        } catch (\Exception $exception) {
            $issue = new Issues(Issues::createIssueMonolog('page', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException();
            $this->alert('error', 'Une erreur est survenue');
        }
    }
}
