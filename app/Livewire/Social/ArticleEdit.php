<?php

namespace App\Livewire\Social;

use App\Enums\Social\ArticleTypeEnum;
use App\Models\Social\Article;
use App\Models\Social\Cercle;
use App\Models\User\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\LaravelOptions\Options;

class ArticleEdit extends Component
{
    use LivewireAlert;
    public Article $article;

    public $cercles;

    public $authors;

    public $title = '';

    public $description = '';

    public $contenue = '';

    public $published = false;

    public $published_at = null;

    public $publish_social = false;

    public $publish_social_at = null;

    public $promote = false;

    public $author = '';

    public $cercle_id = '';

    public $type = '';

    #[Validate('image|max:2048')]
    public $image;

    public function mount(int $id): void
    {
        $this->article = Article::find($id);
        $this->cercles = Cercle::all();
        $this->authors = User::where('admin', true)->get();
    }

    public function update()
    {
        try {
            $this->article->update([
                'title' => $this->title,
                'description' => $this->description,
                'type' => $this->type,
                'contenue' => $this->contenue,
                'published' => $this->published,
                'published_at' => $this->published_at ?? null,
                'publish_social' => $this->publish_social,
                'publish_social_at' => $this->publish_social_at ?? null,
                'promote' => $this->promote,
                'author' => $this->author,
                'cercle_id' => $this->cercle_id,
            ]);
            $this->alert('success', 'Article mis à jour avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', $exception->getMessage());
        }
    }

    #[Title("Edition d'un article")]
    public function render()
    {
        return view('livewire.social.article-edit', [
            'types' => Options::forEnum(ArticleTypeEnum::class)->toArray(),
            'article' => $this->article,
        ])
            ->layout('layouts.app');
    }
}
