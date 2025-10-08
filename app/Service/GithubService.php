<?php

namespace App\Service;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class GithubService
{
    public function __construct(
        protected ApiService $apiService,
    ) {}

    public function fetchUserRepos(string $token): Collection
    {
        return collect($this->apiService->fetch('/user/repos', $token));
    }

    public function fetchUserCommits(string $token, string $authorUsername, Collection $repos, Carbon $date): Collection
    {
        $since = $date->copy()->startOfDay()->toIso8601ZuluString();
        $until = $date->copy()->endOfDay()->toIso8601ZuluString();

        $allCommits = collect();

        foreach ($repos as $repo) {
            $repoBranches = $this->fetchBranches($token, $repo['owner']['login'], $repo['name'])->pluck('name');
            $owner = $repo['owner']['login'];
            $repoName = $repo['name'];

            foreach ($repoBranches as $branch) {
                $url = "/repos/{$owner}/{$repoName}/commits?since={$since}&until={$until}&author={$authorUsername}&sha={$branch}";

                Log::info('Fetching commits', ['url' => $url]);
                $commits = $this->apiService->fetch($url, $token);
                Log::debug('Commits data', ['commits' => $commits]);

                // Attach repository information to each commit
                $commitsWithRepo = collect($commits)->map(function ($commit) use ($repo) {
                    $commit['repository'] = [
                        'name' => $repo['name'],
                        'full_name' => $repo['full_name'],
                        'html_url' => $repo['html_url'],
                        'language' => $repo['language'],
                        'private' => $repo['private'],
                    ];

                    return $commit;
                });

                $allCommits = $allCommits->merge($commitsWithRepo);
            }
        }

        return $allCommits;
    }

    public function fetchBranches(string $token, string $owner, string $repoName): Collection
    {
        $branches = $this->apiService->fetch("/repos/{$owner}/{$repoName}/branches", $token);

        return collect($branches);
    }
}
