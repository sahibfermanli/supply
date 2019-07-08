<?php

namespace App\Http;

use App\Http\Middleware\DirectorLawyer;
use App\Http\Middleware\Finance;
use App\Http\Middleware\FinanceChief;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'Login' => \App\Http\Middleware\Login::class,
        'Admin' => \App\Http\Middleware\Admin::class,
        'UserChief' => \App\Http\Middleware\UserChief::class,
        'User' => \App\Http\Middleware\User::class,
        'Supply' => \App\Http\Middleware\Supply::class,
        'SupplyChief' => \App\Http\Middleware\SupplyChief::class,
        'Director' => \App\Http\Middleware\Director::class,
        'Lawyer' => \App\Http\Middleware\Lawyer::class,
        'LawyerChief' => \App\Http\Middleware\LawyerChief::class,
        'DirectorLawyer' => \App\Http\Middleware\DirectorLawyer::class,
        'Finance' => \App\Http\Middleware\Finance::class,
        'FinanceChief' => \App\Http\Middleware\FinanceChief::class,
        'WareHouseMan' => \App\Http\Middleware\WareHouseMan::class,
        'ApiLogin' => \App\Http\Middleware\Api\Login::class,
    ];
}
