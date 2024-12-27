<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;
use Override;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    #[Override]
    public function boot(): void
    {
        parent::boot();
    }

    #[Override]
    protected function gate(): void
    {
        Gate::define('viewHorizon', fn (User $user) => $user->hasRole('admin'));
    }
}
