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
        Route::get(
            'user/picture',
            [
                'as' => 'api.v1.user.picture.show.self',
                'uses' => 'App\Modules\Core\Controllers\PictureController@show'
            ]
        );

        Route::post(
            'user/picture',
            [
                'as' => 'api.v1.user.picture.store.self',
                'uses' => 'App\Modules\Core\Controllers\PictureController@store'
            ]
        );

        Route::delete(
            'user/picture',
            [
                'as' => 'api.v1.user.picture.destroy.self',
                'uses' => 'App\Modules\Core\Controllers\PictureController@destroy'
            ]
        );

        Route::post(
            'user/{user_id}/picture',
            [
                'as' => 'api.v1.user.picture.post',
                'uses' => 'App\Modules\Core\Controllers\PictureController@store'
            ]
        );

        Route::get(
            'user/{user_id}/picture',
            [
                'as' => 'api.v1.user.picture.show',
                'uses' => 'App\Modules\Core\Controllers\PictureController@show'
            ]
        );

        Route::delete(
            'user/{user_id}/picture',
            [
                'as' => 'api.v1.user.picture.destroy',
                'uses' => 'App\Modules\Core\Controllers\PictureController@destroy'
            ]
        );

        Route::resource(
            'user',
            'App\Modules\Core\Controllers\UserController',
            ['except' => ['create', 'edit']]
        );

        Route::resource(
            'company',
            'App\Modules\Core\Controllers\CompanyController',
            ['except' => ['create', 'edit']]
        );

        Route::resource(
            'company/user',
            'App\Modules\Core\Controllers\CompanyUserController',
            ['only' => ['store', 'show']]
        );

        Route::delete(
            'company/user/{company}/{user}',
            [
                'as' => 'api.v1.company.user.destroy',
                'uses' => 'App\Modules\Core\Controllers\CompanyUserController@destroy'
            ]
        );
    }
);
