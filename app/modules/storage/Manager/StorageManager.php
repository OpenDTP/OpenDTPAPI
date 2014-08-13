<?php

namespace App\Modules\Storage\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Modules\Storage\Models\Store;

class StorageManager
{
    public function store(UploadedFile $file)
    {
        $stores = Store::findByType($file->getMimeType(), $file->getClientOriginalExtension());
        foreach ($stores as $store) {
            print_r($store);
        }
        die;
    }
} 