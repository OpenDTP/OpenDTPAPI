<?php

namespace App\Modules\Document\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Core\Controllers\BaseController;
use App\Modules\Document\Models\Renderer;

class RendererController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $companies = Auth::user()->companies()->getResults();
        $companiesId = [];

        foreach ($companies as $company) {
            $companiesId[] = $company->id;
        }

        $renderers = Renderer::WhereIn('company_id', $companiesId)->get();
        return Response::string(
            ['data' => $renderers->toArray()]
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = [
            'company_id' => 'required|exists:companies,id',
            'connector_id' => 'exists:connectors,id',
            'name' => 'required|unique:renderers,name',
            'address' => 'required|ip'
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
        $renderer = new Renderer;
        $renderer->company_id = Input::get('company_id');
        $renderer->connector_id = Input::get('connector_id');
        $renderer->name = Input::get('name');
        $renderer->address = Input::get('address');
        $renderer->save();

        return Response::string(
            ['messages' => ['Successfully created renderer !']]
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
        $renderer = Renderer::find($id);

        if (is_null($renderer)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown renderer with ID $id"]
                ]
            );
        }

        return $renderer->attributesToArray();
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
            'company_id' => 'exists:companies,id',
            'connector_id' => 'exists:connectors,id',
            'name' => 'unique:renderers,name',
            'address' => 'ip'
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
        $renderer = Renderer::find($id);
        if (is_null($renderer)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown renderer with ID $id"]
                ]
            );
        }
        $renderer->company_id = empty($inputs['company_id']) ? $renderer->company_id : $inputs['company_id'];
        $renderer->connector_id = empty($inputs['connector_id']) ? $renderer->connector_id : $inputs['connector_id'];
        $renderer->name = empty($inputs['name']) ? $renderer->company_id : $inputs['name'];
        $renderer->address = empty($inputs['address']) ? $renderer->company_id : $inputs['address'];
        $renderer->save();

        return Response::string(
            ['messages' => ["Successfully updated renderer $id !"]]
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
        $renderer = Renderer::find($id);

        if (is_null($renderer)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown renderer with ID $id"]
                ]
            );
        }
        $renderer->delete();

        return Response::string(
            ['messages' => ["Renderer $id deleted"]]
        );
    }
}
