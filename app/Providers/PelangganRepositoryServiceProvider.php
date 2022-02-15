<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PelangganRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\PelangganRepositoryInterface',
            'App\Repositories\PelangganRepository'
        );
    }
}
