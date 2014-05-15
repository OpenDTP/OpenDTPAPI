<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * OpenDTP API V1
 */
Route::group(
    [
        'prefix' => 'api/v1/document',
        'before' => 'auth.basic'
    ],
    function () {
        Route::resource(
            'type',
            'App\Modules\Document\Controllers\DocumentTypeController',
            ['except' => ['create', 'edit']]
        );
        Route::resource(
            'connector',
            'App\Modules\Document\Controllers\ConnectorController',
            ['except' => ['create', 'edit']]
        );
    }
);
