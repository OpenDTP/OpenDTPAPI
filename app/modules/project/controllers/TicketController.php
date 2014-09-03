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
