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

        // Step 1: Batch fetch all branches for all repositories
        $branchesRequests = [];
        foreach ($repos as $repo) {
            $owner = $repo['owner']['login'];
            $repoName = $repo['name'];
            $branchesRequests["{$owner}/{$repoName}"] = [
                'uri' => "/repos/{$owner}/{$repoName}/branches",
                'method' => 'GET',
            ];
        }

        Log::info('Fetching branches in batch', ['repositories_count' => count($branchesRequests)]);
        $branchesResults = $this->apiService->batchFetch($branchesRequests, $token);

        // Step 2: Prepare commits requests for all repo/branch combinations
        $commitsRequests = [];
        $repoMap = []; // To map request keys back to repository data

        foreach ($repos as $repo) {
            $owner = $repo['owner']['login'];
            $repoName = $repo['name'];
            $repoKey = "{$owner}/{$repoName}";

            // Check if we successfully fetched branches for this repo
            if (!isset($branchesResults[$repoKey])) {
                Log::warning('Skipping repository due to failed branch fetch', ['repo' => $repoKey]);

                continue;
            }

            $branches = collect($branchesResults[$repoKey])->pluck('name');

            foreach ($branches as $branch) {
                $requestKey = "{$owner}/{$repoName}/{$branch}";
                $commitsRequests[$requestKey] = [
                    'uri' => "/repos/{$owner}/{$repoName}/commits?since={$since}&until={$until}&author={$authorUsername}&sha={$branch}",
                    'method' => 'GET',
                ];

                // Store repository data for later mapping
                $repoMap[$requestKey] = $repo;
            }
        }

        Log::info('Fetching commits in batch', [
            'requests_count' => count($commitsRequests),
            'repositories_with_branches' => count($branchesResults),
        ]);

        // Step 3: Batch fetch all commits
        $commitsResults = $this->apiService->batchFetch($commitsRequests, $token);

        // Step 4: Process results and attach repository information
        $allCommits = collect();

        foreach ($commitsResults as $requestKey => $commits) {
            if (!isset($repoMap[$requestKey])) {
                continue;
            }

            $repo = $repoMap[$requestKey];

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

        Log::info('Commits processing completed', [
            'total_commits_found' => $allCommits->count(),
            'successful_requests' => count($commitsResults),
        ]);

        return $allCommits;
    }
}
