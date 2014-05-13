<?php

namespace App\Modules\Core\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Core\Models\Company;

class CompanyController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return Response::string(
            array(
                'data' => Auth::user()->companies()
            )
        );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $rules = array(
            'name' => 'required|min:3|unique:companies,name',
            'description' => 'max:512'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return Response::string(
                array(
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                )
            );
        } else {
            $company = new Company;
            $company->name = Input::get('name');
            $company->description = Input::get('description');
            $company->save();

            return Response::string(
                array(
                    'messages' => array('Successfully created company !')
                )
            );
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $company = Company::find($id);

        if (!is_null($company)) {
            return Response::string(
                array(
                    'data' => $company->attributesToArray()
                )
            );
        }
        return Response::string(
            array(
                'code' => API_RETURN_404,
                'messages' => array("Unkown company with ID $id")
            )
        );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $inputs = Input::all();
        $rules = array(
            'name' => 'min:3|unique:companies,name',
            'description' => 'max:512'
        );
        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return Response::string(
                array(
                    'code' => API_RETURN_500,
                    'messages' => $errors->getMessages()
                )
            );
        } else {
            $company = Company::find($id);
            if (is_null($company)) {
                return Response::string(
                    array(
                        'code' => API_RETURN_404,
                        'messages' => array("Unkown company with ID $id")
                    )
                );
            }
            $company->name = empty($inputs['name']) ? $company->name : $inputs['name'];
            $company->description = empty($inputs['description']) ? $company->description : $inputs['description'];
            $company->save();

            // redirect
            return Response::string(
                array(
                    'messages' => array("Successfully updated company $id !")
                )
            );
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $company = Company::find($id);

        if (is_null($company)) {
            return Response::string(
                array(
                    'code' => API_RETURN_404,
                    'messages' => array("Unkown company with ID $id")
                )
            );
        }
        $company->delete();
        return Response::string(
            array(
                'messages' => array("Company $id deleted")
            )
        );
	}


}
