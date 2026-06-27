<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

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
        Gate::before(function (User $user, string $ability) {
        if ($user->roles()->where('name', 'Super Admin')->exists()) {
            return true;
        }
    });

    Gate::after(function (User $user, string $ability) {
        $userAbilities = $user->roles()
            ->pluck('abilities') 
            ->flatten()          
            ->unique()
            ->toArray();

        if (in_array($ability, $userAbilities)) {
            return true;
        }
    });
    }
}
