<?php

namespace App\Modules\Core\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Models\Company;

class CompanyController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $companies = Auth::user()->companies()->toArray();

        Log::info('Found companies : ' . print_r($companies, true));
        return Response::string(['data' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = [
            'name' => 'required|min:3|unique:companies,name',
            'description' => 'max:512'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            Log::info('Invalid parameters : [' . implode(', ', $errors->getMessages()) . ']');
            return Response::string(
                [
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                ]
            );
        }
        $company = new Company;
        $company->name = Input::get('name');
        $company->description = Input::get('description');
        $company->save();

        Log::info('Successfully created company '  . $company->id . ' ! [' .
            print_r($company->attributesToArray(), true) . ']');
        return Response::string(
            [
                'messages' => ['Successfully created company ' . $company->id . ' !'],
                'data' => $company->attributesToArray()
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
        $company = Company::find($id);

        if (is_null($company)) {
            Log::info("Unkown company with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown company with ID $id"]
                ]
            );
        }

        Log::info('Found company : ' . print_r($company->attributesToArray(), true));
        return Response::string(['data' => $company->attributesToArray()]);
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
            'name' => 'min:3|unique:companies,name',
            'description' => 'max:512'
        ];
        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            Log::info('Invalid parameters : [' . implode(', ', $errors->getMessages()) . ']');
            return Response::string(
                [
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                ]
            );
        }
        $company = Company::find($id);
        if (is_null($company)) {
            Log::info("Unkown company with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown company with ID $id"]
                ]
            );
        }
        $company->name = empty($inputs['name']) ? $company->name : $inputs['name'];
        $company->description = empty($inputs['description']) ? $company->description : $inputs['description'];
        $company->save();

        Log::info('Updated company : ' . print_r($company->attributesToArray(), true));
        return Response::string(
            [
                'messages' => ["Successfully updated company $id !"],
                'data' => $company->attributesToArray()
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
        $company = Company::find($id);

        if (is_null($company)) {
            Log::info("Unkown company with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown company with ID $id"]
                ]
            );
        }
        $company->delete();

        Log::info("Company $id deleted");
        return Response::string(
            ['messages' => ["Company $id deleted"]]
        );
    }
}
