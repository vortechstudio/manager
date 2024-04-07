<?php

namespace App\Livewire\Social;

use App\Actions\DeleteMedia;
use App\Models\Social\Post\Post;
use App\Notifications\Socials\PostRejectNotification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PostTable extends Component
{
    use LivewireAlert, WithPagination;

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

    public function destroy(int $id): void
    {
        $post = Post::find($id);

        try {
            (new DeleteMedia())->handle('posts', $post->id);
            $post->delete();

            $this->alert('success', "L'article $post->title a bien été supprimé");
        } catch (\Exception $e) {
            $this->alert('error', "Erreur lors de la suppression de l'article $post->title");
        }
    }

    public function reject(int $id): void
    {
        $post = Post::find($id);
        try {
            $post->reject()->create([
                'post_id' => $post->id,
                'reason' => "L'article $post->title a été rejetée pour non respect des règles de la communauté",
            ]);
            $post->user->profil()->update([
                'avertissement' => $post->user->profil->avertissement + 1,
            ]);
            $post->user->notify(new PostRejectNotification($post));
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur lors du rejet de l'article $post->title");
        }
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
