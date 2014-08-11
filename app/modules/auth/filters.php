<?php

Route::filter(
    'auth.basic',
    function () {
        return Auth::basic("login");
    }
);

Route::filter(
    'auth.standard',
    function () {
        if (!Auth::check()) {
            return Redirect::to('login');
        }
    }
);

Route::filter(
    'admin',
    function () {
    }
);

Route::filter(
    'oauth.register',
    function () {
        $id = ResourceServer::getOwnerId();
        if ($id) {
            $user = App\Modules\Core\Models\User::find($id);
            Auth::login($user);
        }
    }
);
