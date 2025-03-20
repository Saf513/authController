<?php

namespace safia\authcontroller;
use Illuminate\Support\ServiceProvider;
use safia\authcontroller\MakeAuthControllerCommand;

class LaravelAuthGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeAuthControllerCommand::class,
            ]);
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}

