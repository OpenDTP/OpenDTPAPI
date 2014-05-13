<?php

namespace App\Modules\Core\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Core\Models\User;

class UserController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $response = $user->attributesToArray();
        $response['companies'] = array();
        foreach ($user->companies()->getResults() as $company) {
            $response['companies'][] = $company->attributesToArray();
        }

        return Response::string(
            array(
                'data' => $response
            )
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = array(
            'login' => 'required|alpha_num',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users,email'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return Response::string(
                array(
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                )
            );
        } else {
            $user = new User;
            $user->login = Input::get('login');
            $user->password = Input::get('password');
            $user->email = Input::get('email');
            $user->save();

            return Response::string(
                array(
                    'messages' => array('Successfully created user !')
                )
            );
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!is_null($user)) {
            $response = $user->attributesToArray();
            $response['companies'] = array();
            foreach ($user->companies()->getResults() as $company) {
                $response['companies'][] = $company->attributesToArray();
            }
            $response = Response::string(
                array(
                    'data' => $response
                )
            );
        } else {
            $response = Response::string(
                array(
                    'code' => API_RETURN_404,
                    'messages' => array("Unkown user with ID $id")
                )
            );
        }

        return $response;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $inputs = Input::all();
        $rules = array(
            'login' => 'alpha_num',
            'password' => 'min:6',
            'email' => 'email|unique:users,email'
        );
        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return Response::string(
                array(
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                )
            );
        } else {
            $user = User::find($id);
            if (is_null($user)) {
                return Response::string(
                    array(
                        'code' => API_RETURN_404,
                        'messages' => array("Unkown user with ID $id")
                    )
                );
            }
            $user->login = empty($inputs['login']) ? $user->login : $inputs['login'];
            $user->password = empty($inputs['password']) ? $user->login : $inputs['password'];
            $user->email = empty($inputs['email']) ? $user->login : $inputs['email'];
            $user->save();

            // redirect
            return Response::string(
                array(
                    'messages' => array("Successfully updated user $id !")
                )
            );
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return Response::string(
                array(
                    'code' => API_RETURN_404,
                    'messages' => array("Unkown user with ID $id")
                )
            );
        }
        $user->delete();
        return Response::string(
            array(
                'messages' => array("User $id deleted")
            )
        );
    }


}
