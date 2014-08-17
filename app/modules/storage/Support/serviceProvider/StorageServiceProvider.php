<?php

namespace App\Modules\Storage\Support\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use App\Modules\Storage\Manager\StorageManager;

class StorageServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['storage'] = $this->app->share(function($app)
            {
                return new StorageManager;
            });
    }
} 