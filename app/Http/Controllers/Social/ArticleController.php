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
use Exception;
use Illuminate\Http\Request;
use Spatie\LaravelOptions\Options;
use Storage;

class ArticleController extends Controller
{
    public function index()
    {
        return view('social.article.index', [
            'articles' => Article::with('author', 'cercle')->get(),
        ]);
    }

    public function show($id)
    {
        return view('social.article.show', [
            'article' => Article::with('author', 'cercle')->find($id),
        ]);
    }

    public function edit($id)
    {
        return view('social.article.edit', [
            'cercles' => Cercle::all(),
            'types' => Options::forEnum(ArticleTypeEnum::class)->toArray(),
            'authors' => User::where('admin', true)->get(),
            'article' => Article::with('author', 'cercle')->find($id),
        ]);
    }

    public function update(Request $request, $id)
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

        $article = Article::find($id);
        $article->update($request->except(['avatar_remove', 'image']));

        if ($request->hasFile('image')) {
            try {
                // On enregistre l'image dans le dossier blog et on déclenche un job permettant de structurer les images pour un header
                $request->image->storeAs(
                    'blog/'.$article->id,
                    'default.'.$request->image->extension()
                );

                dispatch(new ResizeImageJob(
                    filePath: Storage::disk('vortech')->path('blog/'.$article->id.'/default.'.$request->image->getClientOriginalExtension()),
                    directoryUpload: Storage::disk('vortech')->path('blog/'.$article->id),
                    sector: 'article'
                ));

                dispatch(new FormatImageJob(
                    filePath: Storage::disk('vortech')->path('blog/'.$article->id.'/default.'.$request->image->getClientOriginalExtension()),
                    directoryUpload: Storage::disk('vortech')->path('blog/'.$article->id),
                    sector: 'article'
                ));

                Storage::disk('vortech')->delete('blog/'.$article->id.'/default.'.$request->image->getClientOriginalExtension());
            } catch (Exception $exception) {
                $issue = new Issues(Issues::createIssueMonolog('article_image', $exception->getMessage(), [$exception]));
                $issue->createIssueFromException();
            }
        }
        toastr()->addSuccess("L'article a été modifié");

        return redirect()->route('social.articles.show', $article->id);
    }

    public function publish($id)
    {
        if (Article::publish($id)) {
            toastr()->addSuccess("L'article a été publié");
        } else {
            toastr()->addError("Impossible de publier l'article");
        }

        return redirect()->back();
    }

    public function unpublish($id)
    {
        if (Article::unpublish($id)) {
            toastr()->addSuccess("L'article a été dépublie");
        } else {
            toastr()->addError("Impossible de dépublier l'article");
        }

        return redirect()->back();
    }
}
