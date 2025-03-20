<?php

namespace Safia\Authcontroller;

use Illuminate\Support\ServiceProvider;
use Safia\Authcontroller\Commands\MakeAuthControllerCommand;

class AuthControllerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeAuthControllerCommand::class,
            ]);
        }
    }

    public function register()
    {
        //
    }
}
