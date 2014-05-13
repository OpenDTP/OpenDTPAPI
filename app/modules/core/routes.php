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
    array(
        'prefix' => 'api/v1',
        'before' => 'auth.basic'
    ),
    function () {
        Route::resource(
            'user',
            'App\Modules\Core\Controllers\UserController',
            array(
                'except' => array('create', 'edit')
            )
        );
        Route::when('api/v1/user*', 'admin', array('POST', 'PUT', 'PATCH', 'DELETE'));

        Route::resource(
            'company',
            'App\Modules\Core\Controllers\CompanyController',
            array(
                'except' => array('create', 'edit')
            )
        );
        Route::when('api/v1/company*', 'admin', array('POST', 'PUT', 'PATCH', 'DELETE'));

        Route::resource(
            'company/user',
            'App\Modules\Core\Controllers\CompanyUserController',
            array(
                'only' => array('store', 'show')
            )
        );
        Route::delete(
            'company/user/{company}/{user}',
            array(
                'as' => 'api.v1.company.user.destroy',
                'uses' => 'App\Modules\Core\Controllers\CompanyUserController@destroy'
            )
        );
        Route::when('api/v1/company/user*', 'admin');
    }
);
