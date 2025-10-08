<?php

use App\Http\Controllers\FetchCommitsController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('commits', FetchCommitsController::class)->name('commits');

Route::get('/auth/redirect', action: function () {
    return Socialite::driver('github')
        ->scopes(['read:user', 'repo'])
        ->redirect();
})->name('auth.redirect');

Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->user();
    Log::info('GitHub User: '.json_encode($githubUser, JSON_PRETTY_PRINT));

    $user = User::updateOrCreate(
        ['github_id' => $githubUser->id],
        [
            'name' => $githubUser->nickname,
            'email' => $githubUser->email,
            'github_token' => encrypt($githubUser->token),
            'github_refresh_token' => encrypt($githubUser->refreshToken),
            'github_token_expires_at' => now()->addSeconds($githubUser->expiresIn ?? 3600),
        ],
    );

    Auth::login($user);

    return redirect()->route('home');
})->name('auth.callback');
