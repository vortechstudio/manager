<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class DefineVersionCommand extends Command
{
    protected $signature = 'version:define';

    protected $description = 'Détermine la prochaine version du programme.';

    private string $token;

    private string $owner;

    private string $repo;

    public function handle(): void
    {
        $this->token = config('versionbuildaction.gh_token');
        $this->owner = config('versionbuildaction.gh_owner');
        $this->repo = config('versionbuildaction.gh_repository');
        $this->latestTag();
    }

    private function latestTag()
    {
        try {
            $response = Http::withToken($this->token)
                ->get('https://api.github.com/repos/'.$this->owner.'/'.$this->repo.'/tags')
                ->object();

            $latestTag = $response[0]->name;
            $this->info("La version la plus récente est $latestTag.");
            $this->compareCommit($latestTag);
        } catch (HttpResponseException $exception) {
            dd($exception);
        }
    }

    private function compareCommit(string $lastTag)
    {
        [$major, $minor, $patch] = explode('.', str_replace('v', '', $lastTag));
        $commitsResponse = Http::withToken($this->token)
            ->get("https://api.github.com/repos/{$this->owner}/{$this->repo}/compare/$lastTag...production")
            ->json();
        $commits = array_map(function ($commit) {
            if (! str_contains($commit['commit']['message'], 'Merge pull request')) {
                return $commit['commit']['message'];
            }
        }, $commitsResponse['commits']);
        //dd($commits);

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
                $minor = 0;
                $patch = 0;
            } elseif ($hasFeature) {
                $minor++;
                $patch = 0;
            } elseif ($hasFix) {
                $patch++;
            }
        }

        $newTag = "v{$major}.{$minor}.{$patch}";
        $this->info("Nouveau tag: $newTag");
    }
}
