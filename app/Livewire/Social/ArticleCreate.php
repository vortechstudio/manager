<?php

namespace App\Livewire\Social;

use App\Enums\Social\ArticleTypeEnum;
use App\Jobs\ResizeImageJob;
use App\Livewire\Forms\Social\ArticleForm;
use App\Models\Social\Article;
use App\Models\Social\Cercle;
use App\Models\User\User;
use App\Services\Github\Issues;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Monolog\Level;
use Monolog\LogRecord;
use Spatie\LaravelOptions\Options;

class ArticleCreate extends Component
{
    use LivewireAlert, WithFileUploads;

    public ArticleForm $form;

    public $cercles;

    public $authors;

    public function mount()
    {
        $this->cercles = Cercle::all();
        $this->authors = User::where('admin', true)->get();
    }

    public function updatedPublished($value)
    {
        $this->published = $value;
    }

    public function store()
    {
        dd($this->form->all());
        $this->validate();

        try {
            $article = Article::create(
                $this->form->all()
            );
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors de la création de l'article");
            $issue = new Issues(new LogRecord(
                new \DateTimeImmutable('now'),
                'Article',
                Level::Error,
                $exception->getMessage(),
                $exception->getTrace(),
                [
                    'code' => $exception->getCode(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                ]
            ));
            $issue->createIssueFromException(true);
        }

        try {
            // On enregistre l'image dans le dossier blog et on lance un job permettant de structurer les images pour un header
            $this->form->image->storeAs(
                path: 'blog/'.$article->id,
                name: 'default.'.$this->form->image->getClientOriginalExtension(),
            );

            dispatch(new ResizeImageJob(
                filePath: \Storage::disk('vortech')->path('blog/'.$article->id.'/default.'.$this->form->image->getClientOriginalExtension()),
                directoryUpload: \Storage::disk('vortech')->path('blog/'.$article->id),
                sector: 'article'
            ));
        } catch (\Exception $exception) {
            $issue = new Issues(Issues::createIssueMonolog('article_image', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException(true);
        }

        $this->alert('success', "L'article a été créé");
        $this->redirectRoute('social.articles.index');
    }

    #[Title("Création d'un article")]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        //dd($this->cercles);
        try {
            return view('livewire.social.article-create', [
                'types' => Options::forEnum(ArticleTypeEnum::class)->toArray(),
            ])
                ->layout('layouts.app');
        } catch (\Throwable $e) {
            $issue = new Issues(Issues::createIssueMonolog('article', $e->getMessage(), [$e]));
            $issue->createIssueFromException(true);
        }
    }
}
