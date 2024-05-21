<?php

namespace App\Providers;

use App\Models\Ticket;
use App\Models\User;
use App\Policies\Api\V1\TicketPolicy;
use App\Policies\Api\V1\UserPolicy;
use App\Policies\Api\V1\UserTicketsPolicy;
use Dedoc\Scramble\Scramble;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registering policies
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Ticket::class, TicketPolicy::class);
        Gate::policy('user-tickets', UserTicketsPolicy::class);

        Scramble::routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });
    }
}
