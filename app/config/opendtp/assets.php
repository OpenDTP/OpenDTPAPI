<?php

return array(

    'store' => storage_path() . '/assets',
    'users' => [
        'path' => 'users',
        'adapter' => 'App\Modules\Core\Assets\Users',
        'url' => '/assets/users'
    ]

);