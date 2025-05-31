<?php

namespace App\Providers;

use App\Models\Remark;
use App\Models\Ticket;

use App\Policies\TicketPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Register Ticket policy
        Gate::policy(Ticket::class, TicketPolicy::class);

        // Register Remark policy


        // Define policies directly if needed
        Gate::define('transfer-ticket', [TicketPolicy::class, 'transfer']);
        Gate::define('assign-ticket', [TicketPolicy::class, 'assign']);
    }
}
