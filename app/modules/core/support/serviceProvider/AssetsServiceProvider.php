<?php

namespace App\Modules\Core\Support\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use App\Modules\Core\Manager\Assets;

class AssetsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['assets'] = $this->app->share(function ($app) {
            return new Assets;
        });
    }
}
