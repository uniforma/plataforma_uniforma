<?php

namespace App\Providers;

use App\Repositories\Contracts\BaseContract;
use App\Repositories\Contracts\DemandContract;
use App\Repositories\Contracts\SubmissaoContract;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\DemandRepository;
use App\Repositories\Eloquent\SubmisssaoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            BaseContract::class,
            BaseRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
