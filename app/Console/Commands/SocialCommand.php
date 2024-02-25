<?php

namespace App\Console\Commands;

use App\Models\Social\Article;
use App\Models\User\UserProfil;
use App\Notifications\Socials\ArticleWasPublishToSocialNotification;
use Illuminate\Console\Command;

class SocialCommand extends Command
{
    protected $signature = 'social {action}';

    protected $description = 'Commande de controle de la section "Social"';

    protected $issueBase;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        match ($this->argument('action')) {
            'article_publish' => $this->articlePublish(),
        };
    }

    private function articlePublish()
    {
        $articles = Article::where('published', true)
            ->where('status', 'draft')
            ->get();

        foreach ($articles as $article) {
            if ($article->published_at->isPast()) {
                try {
                    try {
                        $article->update([
                            'status' => 'published',
                        ]);
                    } catch (\Exception $e) {
                        \Log::emergency($e->getMessage(), [$e]);
                    }
                } catch (\Exception $exception) {
                    \Log::emergency($exception->getMessage(), [$exception]);
                }
            }
            if ($article->publish_social && $article->publish_social_at->isPast()) {
                try {
                    $article->update([
                        'status' => 'published',
                    ]);
                } catch (\Exception $e) {
                    \Log::emergency($e->getMessage(), [$e]);
                }

                // Publication sur les différents canaux
                foreach (UserProfil::where('notification', true)->with('user')->get() as $user) {
                    $user->user->notify(new ArticleWasPublishToSocialNotification($article));
                }
            }
        }
    }
}
