<?php

namespace App\Http\Controllers;

use App\Service\CommitProcessorService;
use App\Service\GithubService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FetchCommitsController extends Controller
{
    public function __construct(
        protected GithubService $githubService,
        protected CommitProcessorService $commitProcessor,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $date = Carbon::parse($request->query('date', now()->toDateString()))->startOfDay();

        $user = auth()->user();
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $repos = $this->githubService->fetchUserRepos($user->github_token)
            ->filter(fn ($repo) => Carbon::parse($repo['pushed_at'])->greaterThanOrEqualTo($date))
            ->values();

        Log::info('Fetched raw commits', ['count' => $repos->count()]);

        $rawCommits = $this->githubService->fetchUserCommits(
            $user->github_token,
            $user->name,
            $repos,
            $date
        );

        Log::info('Fetched raw commits', ['count' => $rawCommits->count()]);

        $processedCommits = $this->commitProcessor->processCommits($rawCommits);
        $statistics = $this->commitProcessor->getStatistics($processedCommits);

        return response()->json([
            'date' => $date->toIso8601String(),
            'commits' => $processedCommits,
            'statistics' => $statistics,
        ]);
    }
}
