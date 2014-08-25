<?php

namespace App\Modules\Core\Controllers;

use App\Modules\Core\Models\UserCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Models\Company;

class CompanyController extends BaseController
{
    protected $store_rules = [
        'name' => 'required|min:3|unique:companies,name',
        'description' => 'max:512'
    ];
    protected $update_rules = [
        'name' => 'min:3|unique:companies,name',
        'description' => 'max:512'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $companies = Auth::user()->partners()->get()->toArray();

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
        if (!$this->isValid()) {
            return Response::error();
        }
        $company = new Company;
        $company->name = Input::get('name');
        $company->description = Input::get('description');
        $company->save();

        $user_company = new UserCompany;
        $user_company->user_id = Auth::user()->id;
        $user_company->company_id = $company->id;
        $user_company->save();

        Log::info(
            'Successfully created company ' . $company->id . ' ! [' .
            print_r($company->attributesToArray(), true) . ']'
        );
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
        if (!$this->isValid()) {
            return Response::error();
        }
        $inputs = Input::all();
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
