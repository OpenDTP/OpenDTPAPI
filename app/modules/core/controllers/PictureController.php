<?php

namespace App\Modules\Core\Controllers;

use App\Modules\Core\Support\Facades\Assets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class PictureController extends BaseController {

    protected $store_rules = [
        'picture' => 'max:10000|mimes:jpg,jpeg,png'
    ];
    protected $update_rules = [
        'picture' => 'max:10000|mimes:jpg,jpeg,png'
    ];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id)
	{
        if (!$this->isValid()) {
            return Response::error();
        }

        $user = Auth::User();

        if (!empty($user->picture)) {
            Assets::destroy('users', $id, $user->picture);
        }
        $user->picture = Assets::put('users', $id, Input::file('picture'));
        $user->save();

        Log::info(
            'Successfully stored user ' . $user->id . ' picture ! [' .
            print_r($user->attributesToArray(), true) . ']'
        );
        return Response::string(
            [
                'messages' => ['Successfully stored user ' . $user->id . ' picture !'],
                'data' => $user->attributesToArray()
            ]
        );
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
