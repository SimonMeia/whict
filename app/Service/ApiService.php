<?php

namespace App\Service;

use Illuminate\Http\Client\Batch;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
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

    /**
     * Execute multiple GitHub API requests concurrently using Laravel's HTTP batch functionality.
     *
     * @param array $requests Array of request configurations: ['key' => ['uri' => '/path', 'method' => 'GET']]
     * @param string $token Encrypted GitHub token
     * @return array Array of results with same keys as input
     */
    public function batchFetch(array $requests, string $token): array
    {
        $results = [];
        $failedRequests = [];

        $responses = Http::batch(function (Batch $batch) use ($requests, $token) {
            $decryptedToken = decrypt($token);

            foreach ($requests as $key => $request) {
                $method = $request['method'] ?? 'GET';
                $uri = $request['uri'];

                $batch->as($key)
                    ->withHeaders([
                        'Accept' => 'application/vnd.github+json',
                        'X-GitHub-Api-Version' => '2022-11-28',
                    ])
                    ->withToken($decryptedToken)
                    ->{strtolower($method)}("https://api.github.com{$uri}");
            }
        })->progress(function (Batch $batch, int|string $key, Response $response) use (&$results) {
            // Log successful individual request completion
            Log::debug('GitHub API batch request completed', [
                'key' => $key,
                'status' => $response->status(),
            ]);
        })->catch(function (Batch $batch, int|string $key, Response|RequestException $response) use (&$failedRequests) {
            // Handle individual request failures
            $status = $response instanceof Response ? $response->status() : 'exception';
            $body = $response instanceof Response ? $response->body() : $response->getMessage();

            Log::error('GitHub API batch request failed', [
                'key' => $key,
                'status' => $status,
                'body' => $body,
            ]);

            $failedRequests[$key] = [
                'status' => $status,
                'body' => $body,
            ];
        })->send();

        // Process successful responses
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $results[$key] = $response->json();
            }
        }

        // Log batch completion summary
        Log::info('GitHub API batch completed', [
            'total_requests' => count($requests),
            'successful_requests' => count($results),
            'failed_requests' => count($failedRequests),
        ]);

        return $results;
    }
}
