<?php

namespace App\Livewire\Social;

use App\Models\Social\Post\Post;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PostTable extends Component
{
    use LivewireAlert,WithPagination;

    public string $orderField = 'title';
    public string $orderDirection = 'ASC';
    public string $search = '';
    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'title'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public function setOrderField(string $name): void
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }
    public function render()
    {
        return view('livewire.social.post-table', [
            'feeds' => Post::where('title', 'like', "%{$this->search}%")
                ->with('cercle', 'comments', 'images', 'reject')
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
