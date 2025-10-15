<?php

namespace App\Service;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class CommitProcessorService
{
    /**
     * Process raw GitHub commits data into a simplified structure
     *
     * @param  Collection  $commits  Raw commits from GitHub API
     * @param  bool  $includeMerges  Whether to include merge commits
     * @return Collection Processed commits sorted by date descending
     */
    public function processCommits(Collection $commits, bool $includeMerges = true): Collection
    {
        return $commits
            ->unique('sha')
            ->when(!$includeMerges, function ($collection) {
                return $collection->filter(function ($commit) {
                    $message = $commit['commit']['message'] ?? '';
                    $parents = $commit['parents'] ?? [];

                    // Filter out merge commits by checking:
                    // 1. Message starts with "Merge"
                    // 2. Has more than one parent (merge commits have multiple parents)
                    return !(str_starts_with($message, 'Merge') || count($parents) > 1);
                });
            })
            ->map(fn ($commit) => [
                'id' => $commit['sha'],
                'short_id' => substr($commit['sha'], 0, 7),
                'message' => $this->getCommitMessage($commit),
                'author' => [
                    'name' => $commit['commit']['author']['name'] ?? 'Unknown',
                    'email' => $commit['commit']['author']['email'] ?? null,
                    'username' => $commit['author']['login'] ?? null,
                    'avatar_url' => $commit['author']['avatar_url'] ?? null,
                ],
                'date' => Carbon::parse($commit['commit']['author']['date'])->timezone(config('app.timezone')),
                'date_formatted' => Carbon::parse($commit['commit']['author']['date'])->timezone(config('app.timezone'))->format('H:i'),
                'date_human' => Carbon::parse($commit['commit']['author']['date'])->timezone(config('app.timezone'))->diffForHumans(),
                'repository' => [
                    'name' => $commit['repository']['name'] ?? 'Unknown',
                    'full_name' => $commit['repository']['full_name'] ?? null,
                    'url' => $commit['repository']['html_url'] ?? null,
                    'language' => $commit['repository']['language'] ?? null,
                    'is_private' => $commit['repository']['private'] ?? false,
                ],
                'url' => $commit['html_url'],
                'verified' => $commit['commit']['verification']['verified'] ?? false,
            ])
            ->sortByDesc('date')
            ->values();
    }

    /**
     * Extract the first line of the commit message
     */
    protected function getCommitMessage(array $commit): string
    {
        $message = $commit['commit']['message'] ?? '';
        $lines = explode("\n", $message);

        return trim($lines[0]);
    }

    /**
     * Group commits by repository
     */
    public function groupByRepository(Collection $processedCommits): Collection
    {
        return $processedCommits->groupBy('repository.name');
    }

    /**
     * Get commit statistics
     */
    public function getStatistics(Collection $processedCommits): array
    {
        return [
            'total_commits' => $processedCommits->count(),
            'total_repositories' => $processedCommits->pluck('repository.name')->unique()->count(),
            'commits_by_hour' => $processedCommits->groupBy(fn ($commit) => $commit['date']->format('H'))->map->count(),
            'commits_by_repository' => $processedCommits->groupBy('repository.name')->map->count(),
        ];
    }
}
