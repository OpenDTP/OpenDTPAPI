<?php

namespace App\Modules\Core\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Models\User;

class UserController extends BaseController
{
    protected $store_rules = [
        'login' => 'required|alpha_num',
        'password' => 'required|min:6',
        'email' => 'required|email|unique:users,email'
    ];
    protected $update_rules = [
        'login' => 'alpha_num',
        'password' => 'min:6',
        'email' => 'email|unique:users,email'
    ];

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
        $response['companies'] = [];
        foreach ($user->companies() as $company) {
            $response['companies'][] = $company->attributesToArray();
        }

        Log::info('Found user : ' . print_r($response, true));
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
        if (!$this->isValid()) {
            return Response::error();
        }
        $user = new User;
        $user->login = Input::get('login');
        $user->password = Input::get('password');
        $user->email = Input::get('email');
        $user->save();

        Log::info('Successfully created user ' . $user->id . ' ! [' . print_r($user->toArray(), true) . ']');
        return Response::string(
            [
                'messages' => ['Successfully created user ' . $user->id . ' !'],
                'data' => $user->toArray()
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
        $user = User::find($id);

        if (is_null($user)) {
            Log::info("Unkown user with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown user with ID $id"]
                ]
            );
        }

        $response = $user->attributesToArray();
        $response['companies'] = [];
        foreach ($user->companies() as $company) {
            $response['companies'][] = $company->attributesToArray();
        }

        Log::info('Found user : ' . print_r($response, true));
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
        if (!$this->isValid()) {
            return Response::error();
        }
        $user = User::find($id);
        if (is_null($user)) {
            Log::info("Unkown user with ID $id");
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

        Log::info('Updated user : ' . print_r($user->attributesToArray(), true));
        return Response::string(
            [
                'messages' => ["Successfully updated user $id !"],
                'data' => $user->attributesToArray()
            ]
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
            Log::info("Unkown user with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown user with ID $id"]
                ]
            );
        }
        $user->delete();

        Log::info("User $id deleted");
        return Response::string(
            ['messages' => ["User $id deleted"]]
        );
    }
}
