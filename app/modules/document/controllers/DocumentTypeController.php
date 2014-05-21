<?php

namespace App\Modules\Document\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Core\Controllers\BaseController;
use App\Modules\Document\Models\DocumentType;

class DocumentTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $typesQuery = DocumentType::whereNull('company_id');
        $companies = Auth::user()->companies()->getResults();

        foreach ($companies as $company) {
            $typesQuery->orWhere('company_id', $company->id);
        }
        $types = $typesQuery->get();

        return Response::string(['data' => $types->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = [
            'extension' => 'required|alpha_num',
            'company_id' => 'exists:companies,id'
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
        $type = new DocumentType;
        $type->extension = Input::get('extension');
        $type->company_id = Input::get('company_id');
        $type->save();

        return Response::string(
            ['messages' => ['Successfully created document type !']]
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
        $type = DocumentType::find($id);

        if (is_null($type)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown document type with ID $id"]
                ]
            );
        }

        return $type->attributesToArray();
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
            'extension' => 'alpha_num',
            'company_id' => 'exists:companies,id'
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
        $type = DocumentType::find($id);
        if (is_null($type)) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown document type with ID $id"]
                ]
            );
        }
        $type->extension = empty($inputs['extension']) ? $type->extension : $inputs['extension'];
        $type->company_id = empty($inputs['company_id']) ? $type->company_id : $inputs['company_id'];
        $type->save();

        return Response::string(
            ['messages' => ["Successfully updated document type $id !"]]
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
        $type = DocumentType::find($id);

        if ((is_null($type))) {
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown document type with ID $id"]
                ]
            );
        }
        $type->delete();

        return Response::string(
            ['messages' => ["Document type $id deleted"]]
        );
    }
}
