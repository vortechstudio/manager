<?php

namespace App\Livewire\Social;

use App\Models\Social\Cercle;
use App\Models\User\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

class ArticleCreate extends Component
{
    use LivewireAlert;
    public $cercles;
    public $authors;
    public $title = '';
    public $description = '';
    public $contenue = '';
    public $published = false;
    public $published_at = '';
    public $publish_social = false;
    public $publish_social_at = '';
    public $promote = false;
    public $author = '';
    public $cercle_id = '';


    public function mount()
    {
        $this->cercles = Cercle::all();
        $this->authors = User::where('admin', true)->get();
    }
    #[Title("Création d'un article")]
    public function render()
    {
        return view('livewire.social.article-create')
            ->layout("layouts.app");
    }
}
