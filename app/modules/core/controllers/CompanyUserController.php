<?php

namespace App\Modules\Core\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Core\Models\Company;
use App\Modules\Core\Models\UserCompany;
use Illuminate\Support\Facades\Log;

class CompanyUserController extends BaseController
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id'
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            Log::info('Invalid parameters : [' . print_r($errors->getMessages(), true) . ']');
            return Response::string(
                [
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                ]
            );
        }

        $user_company = new UserCompany;
        $user_company->user_id = Input::get('user_id');
        $user_company->company_id = Input::get('company_id');
        $user_company->save();

        Log::info(
            'Successfully associated user ' . Input::get('user_id') .
            ' to company ' . Input::get('company_id') . ' !'
        );
        return Response::string(
            [
                'messages' => [
                    'Successfully associated user ' . Input::get('user_id') .
                    ' to company ' . Input::get('company_id') . ' !'
                ]
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
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown company with ID $id"]
                ]
            );
        }
        $users = $company->users()->toArray();

        Log::info('Found users : ' . print_r($users, true));
        return Response::string(['data' => $users]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($company_id, $user_id)
    {
        $user_company = UserCompany::findRelation($company_id, $user_id);

        if (is_null($user_company)) {
            Log::info("No user $user_id associated to company $company_id !");
            return Response::string(
                [
                    'messages' => ["No user $user_id associated to company $company_id !"]
                ]
            );
        }
        $user_company->delete();

        Log::info("Successfully unassociated user $user_id to company $company_id !");
        return Response::string(
            [
                'messages' => ["Successfully unassociated user $user_id to company $company_id !"]
            ]
        );
    }
}
