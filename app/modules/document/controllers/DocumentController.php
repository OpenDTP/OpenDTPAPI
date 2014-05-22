<?php

namespace App\Modules\Document\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Core\Controllers\BaseController;
use App\Modules\Document\Models\Document;

class DocumentController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $documents = Document::where('user_id', '=', Auth::user()->user_id)->get();

        return Response::string(
            ['data' => $documents->toArray()]
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
            'name' => 'required'
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
        $document = new Document;
        $document->company_id = Input::get('company_id');
        $document->user_id = Auth::user()->user_id;
        $document->name = Input::get('name');
        $document->description = Input::get('description');
        $document->file = 'toto';
        $document->file_type = 1;
        $document->save();

        return Response::string(
            ['messages' => ['Successfully created document !']]
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
        $document = Document::find($id);

        if (is_null($document)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown document with ID $id"]
                ]
            );
        }

        return Response::string(['data' => $document->toArray()]);
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
            'company_id' => 'required|exists:companies,id',
            'name' => 'required'
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
        $document = Renderer::find($id);
        if (is_null($document)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown document with ID $id"]
                ]
            );
        }
        $document->company_id = empty($inputs['company_id']) ? $document->company_id : $inputs['company_id'];
        $document->name = empty($inputs['name']) ? $document->name : $inputs['name'];
        $document->description = empty($inputs['description']) ? $document->description : $inputs['description'];

        return Response::string(
            ['messages' => ["Successfully updated document $id !"]]
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
        $document = Document::find($id);

        if (is_null($document)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown document with ID $id"]
                ]
            );
        }
        $document->delete();

        return Response::string(
            ['messages' => ["Document $id deleted"]]
        );
    }
}
