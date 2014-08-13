<?php

namespace App\Modules\Storage\Connectors\Fs;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Modules\Storage\Connectors\ConnectorAbstract;
use App\Modules\Storage\Models\Store;

class Connector extends ConnectorAbstract
{
    protected $path = '/tmp';

    public function init(Store $store)
    {

    }

    public function store(UploadedFile $file)
    {
        $id = uniqid();;
        $file->move($this->path . DIRECTORY_SEPARATOR . $id, $file->getClientOriginalName());
        return $id;
    }

    public function delete($id)
    {
    }

    public function get($id)
    {
    }
}
