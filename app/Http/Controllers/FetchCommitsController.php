<?php

namespace App\Http\Controllers;

use App\Service\CommitProcessorService;
use App\Service\FakeCommitsDataService;
use App\Service\GithubService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class FetchCommitsController extends Controller
{
    public function __construct(
        protected GithubService $githubService,
        protected CommitProcessorService $commitProcessor,
        protected FakeCommitsDataService $fakeCommitsDataService,
    ) {}

    public function __invoke(Request $request): View|RedirectResponse
    {
        $date = Carbon::parse($request->query('date', now()->toDateString()))->startOfDay();
        $includeMerges = $request->boolean('include_merges', false);
        $devMode = $request->boolean('dev', false);

        $user = auth()->user();
        if (!$user && !$devMode) {
            return redirect()->route('home');
        }

        // Mode développement avec données fictives
        if ($devMode) {
            return view('commits', $this->fakeCommitsDataService->getFakeCommitsForDate($date));
        }

        $repos = $this->githubService->fetchUserRepos($user->github_token)
            ->filter(fn ($repo) => Carbon::parse($repo['pushed_at'])->greaterThanOrEqualTo($date))
            ->values();

        Log::info('Fetched raw repos', ['count' => $repos->count()]);

        $rawCommits = $this->githubService->fetchUserCommits(
            $user->github_token,
            $user->name,
            $repos,
            $date
        );

        Log::info('Fetched raw commits', ['count' => $rawCommits->count()]);

        $processedCommits = $this->commitProcessor->processCommits($rawCommits, $includeMerges);
        $statistics = $this->commitProcessor->getStatistics($processedCommits);

        $data = [
            'date' => $date->toIso8601String(),
            'commits' => $processedCommits,
            'statistics' => $statistics,
        ];

        return view('commits', $data);
    }
}
