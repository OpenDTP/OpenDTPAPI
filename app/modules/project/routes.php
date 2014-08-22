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
        'prefix' => 'api/v1',
        'before' => ['oauth', 'oauth.register']
    ],
    function () {
        Route::resource(
            'project',
            'App\Modules\Project\Controllers\ProjectController',
            ['except' => ['create', 'edit']]
        );

        Route::resource(
            'project/ticket',
            'App\Modules\Project\Controllers\TicketController',
            ['only' => ['show', 'update', 'destroy']]
        );

        Route::resource(
            'project/{id}/ticket',
            'App\Modules\Project\Controllers\ProjectTicketController',
            ['only' => ['index', 'store']]
        );
    }
);
