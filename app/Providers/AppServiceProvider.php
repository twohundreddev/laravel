<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Override;

class AppServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void {}

    public function boot(): void
    {
        $this->configureCommands();

        $this->configureModel();

        Builder::morphUsingUlids();

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }

    protected function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction()
        );
    }

    protected function configureModel(): void
    {
        Model::shouldBeStrict(
            config('app.models.strict')
        );
    }
}
