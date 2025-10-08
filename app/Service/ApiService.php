<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    public function fetch(string $uri, string $token)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github+json',
            'X-GitHub-Api-Version' => '2022-11-28',
        ])
            ->withToken(decrypt($token))
            ->get("https://api.github.com$uri");

        if ($response->failed()) {
            Log::error('GitHub API request failed', [
                'uri' => $uri,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            abort(500, 'Failed to fetch repositories from GitHub.');
        }

        return $response->json();
    }
}
