<?php

namespace App\Livewire\Social;

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

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'id'],
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

    public function render()
    {
        $pages = Page::with('translations', 'creator')
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate(10);

        return view('livewire.social.pages', [
            'pages' => $pages,
        ]);
    }

    public function destroy(int $id)
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

    public function published(int $id)
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

    public function unpublished(int $id)
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
}
