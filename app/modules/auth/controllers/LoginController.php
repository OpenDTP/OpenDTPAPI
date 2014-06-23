<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 22/06/14
 * Time: 20:21
 */

namespace App\Modules\Auth\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Modules\Core\Controllers\BaseController;

class LoginController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Response::string(
            [
                'code' => API_RETURN_400,
                'messages' => ['You are not logged in'],
                'data' => [
                    'logged' => false
                ]
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = [
            'login' => 'required|alpha_num',
            'password' => 'required|min:4'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            Log::info('Invalid parameters : [' . print_r($errors->getMessages(), true) . ']');
            return Response::string(
                [
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                ]
            );
        }

        $logged = Auth::attempt(array('login' => Input::get('login'), 'password' => Input::get('password')), true);

        return Response::string(
            [
               'code' => $logged ? API_RETURN_500 : API_RETURN_400,
               'messages' => [
                   $logged ? 'Successfully logged in' : 'Invalid credentials'
               ]
            ]
        );
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {

    }

} 