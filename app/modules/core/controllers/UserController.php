<?php

namespace App\Modules\Core\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Models\User;

class UserController extends BaseController
{
    protected $store_rules = [
        'login' => 'required|alpha_num',
        'password' => 'required|min:6|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'firstname' => 'min:6|max:255',
        'lastname' => 'min:6|max:255',
        'description' => 'min:6|max:255',
        'company_id' => 'exists:companies,id'
    ];
    protected $update_rules = [
        'login' => 'alpha_num',
        'password' => 'min:6|max:255',
        'email' => 'email|max:255|unique:users,email',
        'firstname' => 'min:6|max:255',
        'lastname' => 'min:6|max:255',
        'description' => 'min:6|max:255',
        'company_id' => 'exists:companies,id'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user()
            ->with('partners', 'company')
            ->first();

        if (is_null($user)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["No user information"]
                ]
            );
        }

        Log::info('Found user : ' . print_r($user->toArray(), true));
        return Response::string(
            ['data' => $user->toArray()]
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
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        $user->description = Input::get('description');
        $user->company_id = Input::get('company_id');
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
        $user = Auth::user()
            ->with('partners', 'company')
            ->find($id);

        if (is_null($user)) {
            Log::info("Unkown user with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown user with ID $id"]
                ]
            );
        }

        Log::info('Found user : ' . print_r($user->toArray(), true));
        return Response::string(
            ['data' => $user->toArray()]
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
        $inputs = Input::all();
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
        $user->password = empty($inputs['password']) ? $user->password : $inputs['password'];
        $user->email = empty($inputs['email']) ? $user->email : $inputs['email'];
        $user->firstname = empty($inputs['firstname']) ? $user->firstname : $inputs['firstname'];
        $user->lastname = empty($inputs['lastname']) ? $user->lastname : $inputs['lastname'];
        $user->description = empty($inputs['description']) ? $user->description : $inputs['description'];
        $user->company_id = empty($inputs['company_id']) ? $user->company_id : $inputs['company_id'];
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
