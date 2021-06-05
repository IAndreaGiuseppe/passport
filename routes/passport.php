<?php

use Illuminate\Support\Facades\Route;

use Laravel\Passport\Features;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\DenyAuthorizationController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\ScopeController;
use Laravel\Passport\Http\Controllers\TransientTokenController;

if (Features::hasAuthorizationFeature()) {
    Route::group([
        'middleware' => config('passport.middleware', ['web', 'auth']),
    ], function () {
        Route::delete('/authorize', [DenyAuthorizationController::class, 'deny'])->name('passport.authorizations.deny');
        Route::post('/authorize', [AuthorizationController::class, 'approve'])->name('passport.authorizations.approve');
        Route::get('/authorize', [AuthorizationController::class, 'authorize'])->name('passport.authorizations.authorize');
    });
}

if (Features::hasAccessTokenFeature()) {
    Route::group([
        'middleware' => ['throttle']
    ], function () {
        Route::post('/token', [AccessTokenController::class, 'issueToken'])->name('passport.token');
    });

    Route::group([
        'middleware' => config('passport.middleware', ['web', 'auth']),
    ], function () {
        Route::delete('/tokens/{token_id}', [AuthorizedAccessTokenController::class, 'destroy'])->name('passport.tokens.destroy');
        Route::get('/tokens', [AuthorizedAccessTokenController::class, 'forUser'])->name('passport.tokens.index');
    });
}

if (Features::hasTransientTokenFeature()) {
    Route::group([
        'middleware' => config('passport.middleware', ['web', 'auth']),
    ], function () {
        Route::post('/token/refresh', [TransientTokenController::class, 'refresh'])->name('passport.token.refresh');
    });
}

if (Features::hasClientsFeature()) {
    Route::group([
        'middleware' => config('passport.middleware', ['web', 'auth']),
    ], function () {
        Route::delete('/clients/{client_id}', [ClientController::class, 'destroy'])->name('passport.clients.destroy');
        Route::put('/clients/{client_id}', [ClientController::class, 'update'])->name('passport.clients.update');
        Route::post('/clients', [ClientController::class, 'store'])->name('passport.clients.store');
        Route::get('/clients', [ClientController::class, 'forUser'])->name('passport.clients.index');
    });
}

if (Features::hasPersonalAccessTokenFeature()) {
    Route::group([
        'middleware' => config('passport.middleware', ['web', 'auth']),
    ], function () {
        Route::delete('/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy'])->name('passport.personal.tokens.destroy');
        Route::post('/personal-access-tokens', [PersonalAccessTokenController::class, 'store'])->name('passport.personal.tokens.store');
        Route::get('/personal-access-tokens', [PersonalAccessTokenController::class, 'forUser'])->name('passport.personal.tokens.index');
        Route::get('/scopes', [ScopeController::class, 'all'])->name('passport.scopes.index');
    });
}
