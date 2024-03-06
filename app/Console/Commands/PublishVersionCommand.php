<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class PublishVersionCommand extends Command
{
    protected $signature = 'version:publish';

    protected $description = 'Publication du dernier TAG';

    private string $token;

    private string $owner;

    private string $repo;

    public function handle(): void
    {
        $this->token = config('versionbuildaction.gh_token');
        $this->owner = config('versionbuildaction.gh_owner');
        $this->repo = config('versionbuildaction.gh_repository');
        $latestTag = $this->latestTag();
        $newTag = $this->compareCommit($latestTag);
        $this->generateTag($newTag, $latestTag);
    }

    private function latestTag()
    {
        try {
            $response = Http::withToken($this->token)
                ->get('https://api.github.com/repos/'.$this->owner.'/'.$this->repo.'/tags')
                ->object();

            return $response[0]->name;
        } catch (HttpResponseException $exception) {
            dd($exception);
        }
    }

    private function compareCommit($lastTag)
    {
        [$major, $minor, $patch] = explode('.', str_replace('v', '', $lastTag));
        $commitsResponse = Http::withToken($this->token)
            ->get("https://api.github.com/repos/{$this->owner}/{$this->repo}/compare/$lastTag...production")
            ->json();
        $commits = array_map(function ($commit) {

            return $commit['commit']['message'];
        }, $commitsResponse['commits']);

        $hasFeature = false;
        $hasFix = false;
        $hasBreakingChange = false;

        foreach ($commits as $commit) {
            if (str_contains($commit, 'feat')) {
                $hasFeature = true;
            }
            if (str_contains($commit, 'fix')) {
                $hasFix = true;
            }
            if (str_contains($commit, 'BREAKING CHANGE')) {
                $hasBreakingChange = true;
            }

            if ($hasBreakingChange) {
                $major++;
            } elseif ($hasFeature) {
                $minor++;
            } elseif ($hasFix) {
                $patch++;
            }
        }

        return "v{$major}.{$minor}.{$patch}";
    }

    private function generateTag($newTag, $oldTag)
    {
        $lastCommit = Http::withToken($this->token)
            ->get("https://api.github.com/repos/$this->owner/$this->repo/commits?per_page=1")
            ->json();
        $lastCommitSha = $lastCommit[0]['sha'] ?? null;
        $tag = Http::withToken($this->token)
            ->post("https://api.github.com/repos/$this->owner/$this->repo/git/tags", [
                'tag' => $newTag,
                'message' => $newTag,
                'object' => $lastCommitSha, // Vous devez obtenir le SHA du dernier commit pour ce tag
                'type' => 'commit',
            ]);

        if ($tag->successful()) {
            $ref = Http::withToken($this->token)
                ->post("https://api.github.com/repos/$this->owner/$this->repo/git/refs", [
                    'ref' => "refs/tags/$newTag",
                ]);
            $body = $this->generateReleaseNote($oldTag, $newTag);
            $this->generateRelease($newTag, $body);
        } else {
            $this->error('Erreur lors de la création du tag : '.$tag->body());
        }
    }

    private function generateReleaseNote($oldTag, $newTag)
    {
        $response = Http::withToken($this->token)
            ->get("https://api.github.com/repos/$this->owner/$this->repo/compare/$oldTag...production")
            ->json();

        $commits = $response['commits'] ?? [];

        // Initialisation des catégories
        $features = [];
        $fixes = [];
        $breakingChanges = [];

        foreach ($commits as $commit) {
            $message = $commit['commit']['message'];
            if (str_contains($message, 'feat')) {
                $features[] = '- '.$message;
            } elseif (str_contains($message, 'fix')) {
                $fixes[] = '- '.$message;
            } elseif (str_contains($message, 'BREAKING CHANGE')) {
                $breakingChanges[] = '- '.$message;
            }
        }

        // Construction du corps de la release
        $body = "# Résumé des changements :\n\n";

        if (! empty($features)) {
            $body .= "\n## Nouvelles fonctionnalités :\n".implode("\n", $features);
        }
        if (! empty($fixes)) {
            $body .= "\n## Corrections de bugs :\n".implode("\n", $fixes);
        }
        if (! empty($breakingChanges)) {
            $body .= "\n## Changements majeurs (Breaking Changes) :\n".implode("\n", $breakingChanges);
        }

        return $body;
    }

    private function generateRelease($newTag, string $body)
    {
        $release = Http::withToken($this->token)
            ->post("https://api.github.com/repos/$this->owner/$this->repo/releases", [
                'tag_name' => $newTag,
                'name' => "$newTag",
                'body' => "$body",
                'draft' => false,
                'prerelease' => false,
            ]);

        if ($release->successful()) {
            $this->info("$newTag créée avec succès !");
        } else {
            $this->error('Erreur lors de la création de la release : '.$release->body());
        }
    }
}
