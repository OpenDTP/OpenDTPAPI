<?php

namespace App\Modules\Storage\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Modules\Storage\Models\Store;

class StorageManager
{
    public function store(UploadedFile $file, Store $store)
    {
        $connectorClass = $store->connector;
        $connector = new $connectorClass($store);
        return $connector->store($file);
    }
}
