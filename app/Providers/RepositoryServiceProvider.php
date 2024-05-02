<?php

namespace App\Providers;

// use App\Repositories\Season\SeasonInterface;
// use App\Repositories\Season\SeasonRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(SeasonInterface::class, SeasonRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
