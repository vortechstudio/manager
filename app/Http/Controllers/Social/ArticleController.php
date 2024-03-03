<?php

namespace App\Http\Controllers\Social;

use App\Enums\Social\ArticleTypeEnum;
use App\Http\Controllers\Controller;
use App\Jobs\FormatImageJob;
use App\Jobs\ResizeImageJob;
use App\Models\Social\Article;
use App\Models\Social\Cercle;
use App\Models\User\User;
use App\Services\Github\Issues;
use Illuminate\Http\Request;
use Monolog\Level;
use Monolog\LogRecord;
use Spatie\LaravelOptions\Options;

class ArticleController extends Controller
{
    public function index()
    {
        return view('social.article.index', [
            'articles' => Article::with('author', 'cercle')->get(),
        ]);
    }

    public function create()
    {
        return view('social.article.create', [
            'cercles' => Cercle::all(),
            'types' => Options::forEnum(ArticleTypeEnum::class)->toArray(),
            'authors' => User::where('admin', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5',
            'description' => 'max:255',
            'contenue' => 'required',
            'author' => 'required',
            'cercle_id' => 'required',
            'type' => 'required',
            'image' => 'image|max:2048',
        ]);

        try {
            $article = Article::create(
                $request->except(['avatar_remove', 'image'])
            );
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            toastr("Erreur lors de la création de l'article", 'error');
            $issue = new Issues(new LogRecord(
                new \DateTimeImmutable('now'),
                'Article',
                Level::Error,
                $exception->getMessage(),
                $exception->getTrace(),
                [
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ],
            ));
            $issue->createIssueFromException();
        }

        try {
            // On enregistre l'image dans le dossier blog et on déclenche un job permettant de structurer les images pour un header
            $request->image->storeAs(
                'blog/'.$article->id,
                'default.'.$request->image->extension()
            );

            dispatch(new ResizeImageJob(
                filePath: \Storage::disk('vortech')->path('blog/'.$article->id.'/default.'.$request->image->getClientOriginalExtension()),
                directoryUpload: \Storage::disk('vortech')->path('blog/'.$article->id),
                sector: 'article'
            ));

            dispatch(new ResizeImageJob(
                filePath: \Storage::disk('vortech')->path('blog/'.$article->id.'/default.'.$request->image->getClientOriginalExtension()),
                directoryUpload: \Storage::disk('vortech')->path('blog/'.$article->id),
                sector: 'article'
            ));

            dispatch(new FormatImageJob(
                filePath: \Storage::disk('vortech')->path('blog/'.$article->id.'/default.'.$request->image->getClientOriginalExtension()),
                directoryUpload: \Storage::disk('vortech')->path('blog/'.$article->id),
                sector: 'article'
            ));

            \Storage::disk('vortech')->delete('blog/'.$article->id.'/default.'.$request->image->getClientOriginalExtension());
        } catch (\Exception $exception) {
            $issue = new Issues(Issues::createIssueMonolog('article_image', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException();
        }

        toastr()->addSuccess("L'article a été créé");
        return redirect()->route('social.articles.index');
    }
}
