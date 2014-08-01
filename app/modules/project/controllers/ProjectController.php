<?php

namespace App\Modules\Project\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Controllers\BaseController;
use App\Modules\Project\Models\Project;

class ProjectController extends BaseController
{
    protected $store_rules = [
        'name' => 'required|min:3',
        'user_id' => 'required|exists:users,id',
        'company_id' => 'required|exists:companies,id',
        'description' => 'max:512'
    ];
    protected $update_rules = [
        'name' => 'min:3',
        'user_id' => 'exists:users,id',
        'company_id' => 'exists:companies,id',
        'description' => 'max:512'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $projects = Project::where('user_id', '=', Auth::user()->id)->get()->toArray();

        Log::info('Found Projects : ' . print_r($projects, true));
        return Response::string(
            ['data' => $projects]
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

        $project = new Project;
        $project->company_id = Input::get('company_id');
        $project->user_id = Auth::user()->user_id;
        $project->name = Input::get('name');
        $project->description = Input::get('description');
        $project->save();

        Log::info('Successfully created project !');
        return Response::string(
            [
                'messages' => ['Successfully created project ' . print_r($project->toArray(), true) . ' !'],
                'data' => $project
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

        Log::info('Found project ' . print_r($project->toArray(), true));
        return Response::string(['data' => $project->toArray()]);
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
        $project->company_id = empty($inputs['company_id']) ? $projectent->company_id : $inputs['company_id'];
        $project->name = empty($inputs['name']) ? $project->name : $inputs['name'];
        $project->description = empty($inputs['description']) ? $project->description : $inputs['description'];

        Log::info('Updated project : ' . print_r($project->attributesToArray(), true));
        return Response::string(
            ['messages' => ["Successfully updated project $id !"]]
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
        $project->delete();

        Log::info("Project $id deleted");
        return Response::string(['messages' => ["Project $id deleted"]]);
    }
}
