<?php

namespace App\Modules\Project\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Controllers\BaseController;
use App\Modules\Project\Models\Team;

class TeamController extends BaseController
{
    protected $update_rules = [
        'name' => 'min:3',
        'description' => 'max:512'
    ];

        /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $teams = Team::where('id', '=', $id)->get()->toArray();

        Log::info('Found Teams : ' . print_r($teams, true));
        return Response::string(
            ['data' => $teams]
        );
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

        $project = Project::find($id);
        if (is_null($project)) {
            Log::info("Unkown project with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown project with ID $id"]
                ]
            );
        }

        $team = new Team;
        $team->id = $project->id;
        $team->user_id = Auth::user()->id;
        $team->name = Input::get('name');
        $team->description = Input::get('description');
        $team->save();

        Log::info('Successfully created team !');
        return Response::string(
            [
                'messages' => ['Successfully created team ' . print_r($team->toArray(), true) . ' !'],
                'data' => $team->toArray()
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
        $team = Team::find($id);

        if (is_null($team)) {
            Log::info("Unkown team with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown team with ID $id"]
                ]
            );
        }

        Log::info('Found team ' . print_r($team->toArray(), true));
        return Response::string(['data' => $team->toArray()]);
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

        if (!$this->isValid()) {
            return Response::error();
        }

        $team = Team::find($id);
        if (is_null($team)) {
            Log::info("Unkown team with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown team with ID $id"]
                ]
            );
        }
        $team->id = empty($inputs['id']) ? $team->id : $inputs['id'];
        $team->name = empty($inputs['name']) ? $team->name : $inputs['name'];
        $team->description = empty($inputs['description']) ? $team->description : $inputs['description'];

        Log::info('Updated team : ' . print_r($team->attributesToArray(), true));
        return Response::string(
            [
                'messages' => ["Successfully updated team $id !"],
                'data' => $team->toArray()
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
        $team = Team::find($id);

        if (is_null($team)) {
            Log::info("Unkown team with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown team with ID $id"]
                ]
            );
        }
        $team->delete();

        Log::info("Team $id deleted");
        return Response::string(['messages' => ["Team $id deleted"]]);
    }
}
