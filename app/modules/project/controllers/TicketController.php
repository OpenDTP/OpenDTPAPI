<?php

namespace App\Modules\Project\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Controllers\BaseController;
use App\Modules\Project\Models\Ticket;

class TicketController extends BaseController
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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);

        if (is_null($ticket)) {
            Log::info("Unkown ticket with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown ticket with ID $id"]
                ]
            );
        }

        Log::info('Found ticket ' . print_r($ticket->toArray(), true));
        return Response::string(['data' => $ticket->toArray()]);
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

        $ticket = Ticket::find($id);
        if (is_null($ticket)) {
            Log::info("Unkown ticket with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown ticket with ID $id"]
                ]
            );
        }
        $ticket->project_id = empty($inputs['project_id']) ? $ticket->project_id : $inputs['project_id'];
        $ticket->name = empty($inputs['name']) ? $ticket->name : $inputs['name'];
        $ticket->description = empty($inputs['description']) ? $ticket->description : $inputs['description'];

        Log::info('Updated ticket : ' . print_r($ticket->attributesToArray(), true));
        return Response::string(
            [
                'messages' => ["Successfully updated ticket $id !"],
                'data' => $ticket->toArray()
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
        $ticket = Ticket::find($id);

        if (is_null($ticket)) {
            Log::info("Unkown ticket with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown ticket with ID $id"]
                ]
            );
        }
        $ticket->delete();

        Log::info("Ticket $id deleted");
        return Response::string(['messages' => ["Ticket $id deleted"]]);
    }
}
