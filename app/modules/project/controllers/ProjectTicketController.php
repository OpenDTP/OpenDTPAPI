<?php

namespace App\Modules\Project\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Controllers\BaseController;
use App\Modules\Project\Models\Ticket;
use App\Modules\Project\Models\Project;

class ProjectTicketController extends BaseController
{
    protected $store_rules = [
        'name' => 'required|min:3',
        'description' => 'max:512'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($project_id)
    {
        $tickets = Ticket::where('project_id', '=', $project_id)->get()->toArray();

        Log::info('Found Tickets : ' . print_r($tickets, true));
        return Response::string(
            ['data' => $tickets]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($project_id)
    {
        if (!$this->isValid()) {
            return Response::error();
        }

        $project = Project::find($project_id);
        if (is_null($project)) {
            Log::info("Unkown project with ID $project_id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown project with ID $project_id"]
                ]
            );
        }

        $ticket = new Ticket;
        $ticket->project_id = $project->id;
        $ticket->user_id = Auth::user()->id;
        $ticket->name = Input::get('name');
        $ticket->description = Input::get('description');
        $ticket->save();

        Log::info('Successfully created ticket !');
        return Response::string(
            [
                'messages' => ['Successfully created ticket ' . print_r($ticket->toArray(), true) . ' !'],
                'data' => $ticket->toArray()
            ]
        );
    }
}
