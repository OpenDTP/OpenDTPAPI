<?php

/**
 * OpenDTP API V1
 * OAuth2 authentification
 */
Route::post(
    'oauth/access_token',
    function () {
        return AuthorizationServer::performAccessTokenFlow();
    }
);
