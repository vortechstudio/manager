<?php

namespace App\Livewire\Social;

use App\Enums\Social\ArticleTypeEnum;
use App\Models\Social\Article;
use App\Models\Social\Cercle;
use App\Models\User\User;
use App\Services\Github\Issues;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Monolog\Level;
use Monolog\LogRecord;
use Spatie\LaravelOptions\Options;
use Vortechstudio\Helpers\Helpers;

class ArticleCreate extends Component
{
    use LivewireAlert, WithFileUploads;
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
    public $type = '';

    #[Validate('image|max:2048')]
    public $image;

    public function mount()
    {
        $this->cercles = Cercle::all();
        $this->authors = User::where('admin', true)->get();
    }

    public function updatedPublished($value)
    {
        $this->published = $value;
    }

    public function submit()
    {
        $this->validate([
            "title" => "required|alpha_num|min:5",
            "description" => "max:255",
            "contenue" => "required",
            "cercle_id" => "required",
            "author" => "required",
            "type" => "required"
        ]);

        try {
            Article::create([
                "title" => $this->title,
                "description" => $this->description,
                "type" => $this->type,
                "contenue" => $this->contenue,
                "published" => $this->published,
                "published_at" => $this->published_at ?? null,
                "publish_social" => $this->publish_social,
                "publish_social_at" => $this->publish_social_at ?? null,
                "promote" => $this->promote,
                "author" => $this->author,
                "cercle_id" => $this->cercle_id
            ]);
        }catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert("error", "Erreur lors de la création de l'article");
            $issue = new Issues(new LogRecord(
                new \DateTimeImmutable("now"),
                "Article",
                Level::Error,
                $exception->getMessage(),
                $exception->getTrace(),
                [
                    "code" => $exception->getCode(),
                    "line" => $exception->getLine(),
                    "file" => $exception->getFile()
                ]
            ));
            $issue->createIssueFromException(true);
        }

        $this->alert("success", "L'article a été créé");
        $this->redirectRoute('social.articles.index');
    }

    #[Title("Création d'un article")]
    public function render()
    {
        return view('livewire.social.article-create', [
            "types" => Options::forEnum(ArticleTypeEnum::class)->toArray()
        ])
            ->layout("layouts.app");
    }
}
