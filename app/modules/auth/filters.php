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
