<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(
    function ($request) {
        //
    }
);


App::after(
    function ($request, $response) {
    }
);

// Error management
// Catch unmanaged errors and reformat exception to display
App::error(
    function (Exception $exception) {
        Log::error('Error : ' . $exception->getMessage());
        return Response::json(
            [
                'version' => API_VERSION,
                'code' => $exception->getCode(),
                'messages' => $exception->getMessage(),
                'data' => ''
            ]
        );
    }
);

App::fatal(
    function (Exception $exception) {
        Log::error('Runtime Exception : ' . $exception->getMessage());
        return Response::json(
            [
                'version' => API_VERSION,
                'code' => $exception->getCode(),
                'messages' => $exception->getMessage(),
                'data' => ''
            ]
        );
    }
);

App::missing(
    function (Exception $exception) {
        Log::error('Missing Route Exception : ' . $exception->getMessage());
        return Response::json(
            [
                'version' => API_VERSION,
                'code' => API_RETURN_404,
                'messages' => 'Not Found',
                'data' => ''
            ]
        );
    }
);
