<?php

namespace App\Service;

use Carbon\Carbon;

class FakeCommitsDataService
{
    public function getFakeCommitsForDate(Carbon $date): array
    {
        $fakeCommits = collect([
            [
                'sha' => 'abc123def456',
                'short_id' => 'abc123d',
                'message' => 'feat: Add user authentication system',
                'date' => $date->copy()->setTime(9, 30)->toIso8601String(),
                'date_formatted' => $date->copy()->setTime(9, 30)->format('H:i'),
                'date_human' => $date->copy()->setTime(9, 30)->diffForHumans(),
                'url' => 'https://github.com/example/repo1/commit/abc123def456',
                'verified' => true,
                'author' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4',
                ],
                'repository' => [
                    'name' => 'awesome-project',
                    'url' => 'https://github.com/example/awesome-project',
                    'language' => 'PHP',
                ],
            ],
            [
                'sha' => 'def456ghi789',
                'short_id' => 'def456g',
                'message' => 'fix: Resolve database connection timeout',
                'date' => $date->copy()->setTime(11, 15)->toIso8601String(),
                'date_formatted' => $date->copy()->setTime(11, 15)->format('H:i'),
                'date_human' => $date->copy()->setTime(11, 15)->diffForHumans(),
                'url' => 'https://github.com/example/repo2/commit/def456ghi789',
                'verified' => false,
                'author' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4',
                ],
                'repository' => [
                    'name' => 'backend-api',
                    'url' => 'https://github.com/example/backend-api',
                    'language' => 'TypeScript',
                ],
            ],
            [
                'sha' => 'ghi789jkl012',
                'short_id' => 'ghi789j',
                'message' => 'docs: Update README with installation instructions',
                'date' => $date->copy()->setTime(14, 45)->toIso8601String(),
                'date_formatted' => $date->copy()->setTime(14, 45)->format('H:i'),
                'date_human' => $date->copy()->setTime(14, 45)->diffForHumans(),
                'url' => 'https://github.com/example/repo3/commit/ghi789jkl012',
                'verified' => true,
                'author' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4',
                ],
                'repository' => [
                    'name' => 'documentation',
                    'url' => 'https://github.com/example/documentation',
                    'language' => 'Markdown',
                ],
            ],
            [
                'sha' => 'jkl012mno345',
                'short_id' => 'jkl012m',
                'message' => 'refactor: Improve code structure in payment module',
                'date' => $date->copy()->setTime(16, 20)->toIso8601String(),
                'date_formatted' => $date->copy()->setTime(16, 20)->format('H:i'),
                'date_human' => $date->copy()->setTime(16, 20)->diffForHumans(),
                'url' => 'https://github.com/example/repo4/commit/jkl012mno345',
                'verified' => true,
                'author' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4',
                ],
                'repository' => [
                    'name' => 'payment-service',
                    'url' => 'https://github.com/example/payment-service',
                    'language' => 'JavaScript',
                ],
            ],
            [
                'sha' => 'mno345pqr678',
                'short_id' => 'mno345p',
                'message' => 'test: Add unit tests for user service',
                'date' => $date->copy()->setTime(17, 50)->toIso8601String(),
                'date_formatted' => $date->copy()->setTime(17, 50)->format('H:i'),
                'date_human' => $date->copy()->setTime(17, 50)->diffForHumans(),
                'url' => 'https://github.com/example/repo5/commit/mno345pqr678',
                'verified' => false,
                'author' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'avatar_url' => 'https://avatars.githubusercontent.com/u/1?v=4',
                ],
                'repository' => [
                    'name' => 'user-management',
                    'url' => 'https://github.com/example/user-management',
                    'language' => 'PHP',
                ],
            ],
        ]);

        $fakeStatistics = [
            'total_commits' => $fakeCommits->count(),
            'total_repositories' => $fakeCommits->pluck('repository.name')->unique()->count(),
            'commits_by_hour' => collect([
                '09' => 1,
                '11' => 1,
                '14' => 1,
                '16' => 1,
                '17' => 1,
            ]),
            'commits_by_repository' => $fakeCommits->groupBy('repository.name')->map->count(),
        ];

        return [
            'date' => $date->toIso8601String(),
            'commits' => $fakeCommits,
            'statistics' => $fakeStatistics,
        ];
    }
}
