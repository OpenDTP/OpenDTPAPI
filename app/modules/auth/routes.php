<?php

/**
 * OpenDTP API V1
 */
Route::resource(
    'login',
    'App\Modules\Auth\Controllers\LoginController',
    ['except' => ['create', 'edit']]
);
