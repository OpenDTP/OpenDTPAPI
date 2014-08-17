<?php

namespace App\Modules\Core\Controllers;

use App\Modules\Core\Support\Facades\Assets;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Models\User;
use App\Modules\Core\Models\Asset;

class PictureController extends BaseController
{
    protected $store_rules = [
        'picture' => 'max:10000|mimes:jpg,jpeg,png'
    ];
    protected $update_rules = [
        'picture' => 'max:10000|mimes:jpg,jpeg,png'
    ];

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

        $user = User::find($id);
        if (is_null($user)) {
            Log::info("Unknown user with id $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unknown user with id $id"]
                ]
            );
        }

        if (!empty($user->picture)) {
            Assets::destroy('users', $user->picture);
        }
        $asset = Assets::put('users', Input::file('picture'));
        $user->picture = $asset->id;
        $user->save();

        Log::info(
            'Successfully stored user ' . $user->id . ' picture ! [' .
            print_r($user->attributesToArray(), true) . ']'
        );
        return Response::string(
            [
                'messages' => ['Successfully stored user ' . $user->id . ' picture !'],
                'data' => $asset->attributesToArray()
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
            Log::info("Unknown user with id $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unknown user with id $id"]
                ]
            );
        }
        if (is_null($user->picture)) {
            Log::info("No picture for user with id $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["No picture for user with id $id"]
                ]
            );
        }
        $file = Assets::get('users', $user->picture);
        $asset = Asset::find($user->picture);

        return Response::make(file_get_contents($file), 200)
            ->header('Content-Type', $asset->mime)
            ->header('Content-Length', filesize($file));
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
            Log::info("Unknown user with id $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unknown user with id $id"]
                ]
            );
        }
        Assets::destroy('users', $user->picture);
        $user->picture = null;
        $user->save();

        Log::info("User $id deleted");
        return Response::string(
            ['messages' => ["User $id picture deleted"]]
        );
    }
}
