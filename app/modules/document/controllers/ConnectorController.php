<?php

namespace App\Modules\Document\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Core\Controllers\BaseController;
use App\Modules\Document\Models\Connector;

class ConnectorController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $connectors = Connector::all();

        return Response::string(['data' => $connectors->toArray()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = [
            'name' => 'required|min:3|unique:connectors,name',
            'active' => 'required|in:0,1'
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
        $connector = new Connector;
        $connector->name = Input::get('name');
        $connector->active = Input::get('active');
        $connector->save();

        return Response::string(['message' => 'Successfully registered connector !']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $connector = Connector::find($id);

        if (is_null($connector)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown connector with ID $id"]
                ]
            );
        }

        return Response::string(['data' => $connector->attributesToArray()]);
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
            'name' => 'min:3|unique:connectors,name',
            'active' => 'in:0,1'
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
        $connector = Connector::find($id);
        if (is_null($connector)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown connector with ID $id"]
                ]
            );
        }
        $connector->name = empty($inputs['name']) ? $connector->name : $inputs['name'];
        $connector->active = empty($inputs['active']) ? $connector->active : $inputs['active'];
        $connector->save();

        return Response::string(
            ['messages' => ["Successfully updated connector $id !"]]
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
        $connector = Connector::find($id);

        if (is_null($connector)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown connector with ID $id"]
                ]
            );
        }
        $connector->delete();
        return Response::string(['messages' => ["Connector $id deleted"]]);
    }
}
