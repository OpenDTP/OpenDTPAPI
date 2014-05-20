<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 11/05/14
 * Time: 23:49
 */

namespace App\Modules\Core\Controllers;

use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use \Illuminate\Routing\Controller;

class BaseController extends Controller
{
    protected function setupLayout()
    {
        Response::macro(
            'string',
            function ($value) {
                $value = array_merge(
                    array(
                        'version' => API_VERSION,
                        'code' => API_RETURN_200,
                        'messages' => array('Success !'),
                        'data' => ''
                    ),
                    $value
                );
                return Response::json($value);
            }
        );
    }
}
