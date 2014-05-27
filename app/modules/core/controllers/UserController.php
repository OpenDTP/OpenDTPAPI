<?php

namespace App\Modules\Core\Controllers;

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

        if (is_null($user)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["No user information"]
                ]
            );
        }
        $response = $user->attributesToArray();
        $response['companies'] = array();
        foreach ($user->companies()->getResults() as $company) {
            $response['companies'][] = $company->attributesToArray();
        }

        return Response::string(
            ['data' => $response]
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
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users,email'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return Response::string(
                [
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                ]
            );
        }
        $user = new User;
        $user->login = Input::get('login');
        $user->password = Input::get('password');
        $user->email = Input::get('email');
        $user->save();

        return Response::string(
            ['messages' => ['Successfully created user !']]
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
        $user = User::find($id);

        if (is_null($user)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown user with ID $id"]
                ]
            );
        }

        $response = $user->attributesToArray();
        $response['companies'] = array();
        foreach ($user->companies()->getResults() as $company) {
            $response['companies'][] = $company->attributesToArray();
        }
        return Response::string(
            ['data' => $response]
        );
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
        $rules = [
            'login' => 'alpha_num',
            'password' => 'min:6',
            'email' => 'email|unique:users,email'
        ];
        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return Response::string(
                [
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                ]
            );
        }
        $user = User::find($id);
        if (is_null($user)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown user with ID $id"]
                ]
            );
        }
        $user->login = empty($inputs['login']) ? $user->login : $inputs['login'];
        $user->password = empty($inputs['password']) ? $user->login : $inputs['password'];
        $user->email = empty($inputs['email']) ? $user->login : $inputs['email'];
        $user->save();

        return Response::string(
            ['messages' => ["Successfully updated user $id !"]]
        );
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
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown user with ID $id"]
                ]
            );
        }
        $user->delete();

        return Response::string(
            ['messages' => ["User $id deleted"]]
        );
    }
}
