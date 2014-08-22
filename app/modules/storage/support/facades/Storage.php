<?php

namespace App\Modules\Storage\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Storage extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'storage';
    }
}
