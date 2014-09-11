<?php

namespace App\Modules\Document\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Controllers\BaseController;
use App\Modules\Document\Models\Document;
use App\Modules\Storage\Support\Facades\Storage;
use App\Modules\Storage\Models\Store;
use App\Modules\Document\Protocols\Indesign;
use Illuminate\Support\Facades\Config;

class DocumentController extends BaseController
{
    protected $store_rules = [
        'company_id' => 'required|exists:companies,id',
        'name' => 'required'
    ];
    protected $update_rules = [
        'company_id' => 'required|exists:companies,id',
        'name' => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $documents = Document::where('user_id', '=', Auth::user()->user_id)->get()->toArray();

        Log::info('Found documents : ' . print_r($documents, true));
        return Response::string(
            ['data' => $documents]
        );
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

        $file = Input::file('file');

        try {
            $file_id = Storage::store($file, Store::find(1));
        } catch (\Exception $e) {
            Log::info(
                'Failed to import document file [' . $file->getClientOriginalName() . '] : '
                . print_r($e, true)
            );
            return Response::string(
                [
                    'code' => API_RETURN_500,
                    'messages' => ['Failed to import document file : ' . $e->getMessage()]
                ]
            );
        }

        $document = new Document;
        $document->company_id = Input::get('company_id');
        $document->user_id = Auth::user()->id;
        $document->name = Input::get('name');
        $document->description = Input::get('description');
        $document->file = $file->getClientOriginalName();
        $document->file_id = $file_id;
        $document->store_id = 1;
        $document->type = 1;
        $document->save();

        Log::info('Successfully created document !');
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
            Log::info("Unkown document with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown document with ID $id"]
                ]
            );
        }
        Log::info('Found document ' . print_r($document->toArray(), true));
        return Response::string(['data' => $document->toArray()]);
    }

    /*
    * Export a document to HTML
    *
    * @param  int $id
    * @return Response
    */
    public function export($id)
    {
      $document = Document::find($id);

      if (is_null($document)) {
          Log::info("Unkown document with ID $id");
          return Response::string(
              [
                  'code' => API_RETURN_404,
                  'messages' => ["Unkown document with ID $id"]
              ]
          );
      }
      $renderer_protocol = new Indesign\Soap();
      $scripts_params = array(
        'document' => Config::get('opendtp/renderers/indesign/config.documents_path').$document->file_id.'/'.$document->file
      );
      $response = $renderer_protocol->request('html_export', $scripts_params);
      Log::info('Found document ' . print_r($document->toArray(), true));
      if ($response['errorNumber'] != 0) {
        return Response::string(
          [
            'code' => API_RETURN_500,
            'messages' => ["InDesign server : code ".$response['errorNumber']." : ".$response['errorString']]
          ]
        );
      }
      return Response::string(['data' => $response['scriptResult']['data']]);
    }

    /**
    * Preview as an image the specified resource.
    *
    * @param  int $id
    * @return Response
    */
    public function preview($id)
    {
      if (!$this->isValid()) {
        return Response::error();
      }
      $document = Document::find($id);
      if (is_null($document)) {
        Log::info("Unkown document with ID $id");
        return Response::string(
          [
            'code' => API_RETURN_404,
            'messages' => ["Unkown document with ID $id"]
          ]
        );
      }
      $renderer_protocol = new Indesign\Soap();
      $scripts_params = array(
        'document' => Config::get('opendtp/renderers/indesign/config.documents_path').$document->file_id.'/'.$document->file
      );
      $response = $renderer_protocol->request('export', $scripts_params);
      if ($response['errorNumber'] != 0) {
        return Response::string(
          [
            'code' => API_RETURN_500,
            'messages' => ["InDesign server : code ".$response['errorNumber']." : ".$response['errorString']]
          ]
        );
      }
      return Response::string(['data' => $response['scriptResult']['data']]);
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
        $document = Document::find($id);
        if (is_null($document)) {
            Log::info("Unkown document with ID $id");
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

        Log::info('Updated document : ' . print_r($document->attributesToArray(), true));
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
            Log::info("Unkown document with ID $id");
            return Response::string(
                [
                    'code' => API_RETURN_404,
                    'messages' => ["Unkown document with ID $id"]
                ]
            );
        }
        $document->delete();

        Log::info("Document $id deleted");
        return Response::string(['messages' => ["Document $id deleted"]]);
    }
}
