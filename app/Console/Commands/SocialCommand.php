<?php

namespace App\Console\Commands;

use App\Models\Social\Article;
use App\Models\Social\Event;
use App\Models\Social\Post\Post;
use App\Models\Social\Post\PostComment;
use App\Models\User\User;
use App\Models\User\UserProfil;
use App\Notifications\Socials\ArticleWasPublishToSocialNotification;
use App\Notifications\Socials\IsPublishNotification;
use App\Notifications\System\AlertStatusEventNotification;
use App\Notifications\Users\AvertissementNotification;
use App\Notifications\Users\UnbannedNotification;
use Exception;
use Illuminate\Console\Command;
use Log;

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
            'events' => $this->verifyStatusEvents(),
            'eventPublish' => $this->verifyEventIsPublish(),
            'postIsBlocked' => $this->verifyPostIsBlocked(),
            'postCommentIsBlocked' => $this->verifyPostCommentIsBlocked(),
            'accountBanned' => $this->verifyAccountBanned(),
        };
    }

    private function articlePublish()
    {
        $articles = Article::where('published', true)
            ->get();

        foreach ($articles as $article) {
            if ($article->published_at->isPast()) {
                try {
                    try {
                        $article->update([
                            'status' => 'published',
                        ]);
                    } catch (Exception $e) {
                        Log::emergency($e->getMessage(), [$e]);
                    }
                } catch (Exception $exception) {
                    Log::emergency($exception->getMessage(), [$exception]);
                }
            }
            if ($article->publish_social && $article->publish_social_at->isPast()) {
                try {
                    $article->update([
                        'status' => 'published',
                    ]);
                } catch (Exception $e) {
                    Log::emergency($e->getMessage(), [$e]);
                }

                // Publication sur les différents canaux
                foreach (UserProfil::where('notification', true)->with('user')->get() as $user) {
                    $user->user->notify(new ArticleWasPublishToSocialNotification($article));
                }
            }
        }
    }

    private function verifyStatusEvents()
    {
        foreach (Event::all() as $event) {
            $calc_diff_in_day = now()->startOfDay()->diffInDays($event->end_at->endOfDay());
            $alert_pass_submitting = intval($calc_diff_in_day * 75 / 100);
            $alert_pass_evaluating = intval($calc_diff_in_day * 45 / 100);
            $alert_pass_closed = intval($calc_diff_in_day * 5 / 100);
            if ($event->status = 'progress') {
                if ($calc_diff_in_day <= $alert_pass_submitting) {
                    $this->notifyAdmin($event, 'Vous devez impérativement passer cet évènement en <strong>Soumission</strong>');
                }
            }

            if ($event->status = 'submitting') {
                if ($calc_diff_in_day <= $alert_pass_evaluating) {
                    $this->notifyAdmin($event, 'Vous devez impérativement passer cet évènement en <strong>Evaluation</strong>');
                }
            }

            if ($event->status == 'evaluation') {
                if ($calc_diff_in_day <= $alert_pass_closed) {
                    $this->notifyAdmin($event, "Vous devez impérativement passer cet évènement en <strong>Cloture</strong>. Par défault il le sera à la date et heure de la fin de l'évènement.");
                }
                if (now()->endOfDay() == $event->end_at->endOfDay()) {
                    $event->update([
                        'status' => 'closed',
                    ]);

                    $this->notifyAdmin($event, "L'évènement à été automatiquement cloturer");
                }
            }
        }
    }

    private function notifyAdmin(Event $event, string $message)
    {
        foreach (User::where('admin', true)->get() as $user) {
            $user->notify(new AlertStatusEventNotification($event, $message));
        }
    }

    private function verifyEventIsPublish()
    {
        foreach (Event::all() as $event) {
            if ($event->start_at->startOfDay() == now()->startOfDay()) {
                $event->notify(new IsPublishNotification('event', $event));
            }
        }
    }

    private function verifyPostIsBlocked()
    {
        foreach (Post::all() as $post) {
            if ($post->reject()->exists()) {
                if ($post->reject->created_at->startOfDay() == now()->subDays(7)->startOfDay()) {
                    if ($post->user->profil->avertissement > 3) {
                        $post->user->profil->banned = true;
                        $post->user->profil->banned_at = now();
                        $post->user->profil->banned_for = now()->addDays(7)->startOfDay();
                        $post->user->profil->save();

                        $post->user->logs()->create([
                            'action' => 'Banissement du compte pour une durée de 7 jours',
                            'user_id' => $post->user->id,
                        ]);
                    } else {
                        $post->user->profil->avertissement++;
                        $post->user->profil->save();

                        $post->user->notify(new AvertissementNotification(
                            $post->user,
                            "Non respect des règles éthiques d'utilisations du service Vortech Lab"
                        ));
                        $post->user->logs()->create([
                            'action' => "Avertissement pour non respect des conditions d'utilisations de Vortech Lab",
                            'user_id' => $post->user->id,
                        ]);

                        $post->delete();
                    }
                }
            }
        }
    }

    private function verifyPostCommentIsBlocked()
    {
        foreach (PostComment::all() as $comment) {
            if ($comment->reject()->exists()) {
                if ($comment->reject->created_at->startOfDay() == now()->subDays(7)->startOfDay()) {
                    if ($comment->user->profil->avertissance > 3) {
                        $comment->user->profil->banned = true;
                        $comment->user->profil->banned_at = now();
                        $comment->user->profil->banned_for = now()->addDays(7)->startOfDay();
                        $comment->user->profil->save();

                        $comment->user->logs()->create([
                            'action' => 'Banissement du compte pour une durée de 7 jours',
                            'user_id' => $comment->user->id,
                        ]);
                    } else {
                        $comment->user->profil->avertissance++;
                        $comment->user->profil->save();

                        $comment->user->notify(new AvertissementNotification(
                            $comment->user,
                            "Non respect des règles éthiques d'utilisations du service Vortech Lab"
                        ));
                        $comment->user->logs()->create([
                            'action' => "Avertissement pour non respect des conditions d'utilisations de Vortech Lab",
                            'user_id' => $comment->user->id,
                        ]);

                        $comment->delete();
                    }
                }
            }
        }
    }

    private function verifyAccountBanned()
    {
        foreach (UserProfil::all() as $profil) {
            if ($profil->banned && $profil->banned_for->startOfDay == now()->startOfDay()) {
                $profil->update([
                    'banned' => false,
                    'banned_at' => null,
                    'banned_for' => null,
                    'avertissement' => 0,
                ]);

                $profil->user->notify(new UnbannedNotification($profil->user));
            }
        }
    }
}
