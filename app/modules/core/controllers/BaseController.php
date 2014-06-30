<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 11/05/14
 * Time: 23:49
 */

namespace App\Modules\Core\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    protected $store_rules = [];
    protected $update_rules = [];
    protected $errors = null;

    protected function setupLayout()
    {
        Response::macro(
            'string',
            function ($value) {
                $value = array_merge(
                    [
                        'version' => API_VERSION,
                        'code' => API_RETURN_200,
                        'messages' => ['Success !'],
                        'data' => ''
                    ],
                    $value
                );
                return Response::json($value);
            }
        );

        Response::macro(
            'error',
            function () {
                $value = [
                    'version' => API_VERSION,
                    'code' => API_RETURN_500,
                    'messages' => $this->getErrors(),
                    'data' => ''
                ];
                return Response::json($value);
            }
        );
    }

    protected function failed()
    {
        Log::info('Invalid parameters : [' . print_r($this->getErrors(), true) . ']');
    }

    protected function passed()
    {
    }

    protected function validate($rules)
    {
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            Log::info('Invalid parameters : [' . print_r($errors->getMessages(), true) . ']');
            $this->errors = $errors->getMessages();
            $this->failed();

            return false;
        }
        $this->passed();

        return true;
    }

    protected function isValid()
    {
        $method = Request::method();
        $rules = null;

        if ($method == 'POST') {
            $rules = $this->store_rules;
        } elseif ($method == 'PUT' || $method == 'PATCH') {
            $rules = $this->update_rules;
        }
        if (empty($rules)) {
            return true;
        }

        return $this->validate($rules);
    }

    protected function getErrors()
    {
        return $this->errors;
    }
}
