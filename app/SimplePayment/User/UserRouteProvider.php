<?php

namespace SimplePayment\User;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use SimplePayment\User\Http\Controllers\UserController;

class UserRouteProvider extends RouteServiceProvider
{
    public function map(): void
    {
        Route::post(
            '/api/user',
            [UserController::class, 'createUser']
        )->name('users.store');
    }
}
