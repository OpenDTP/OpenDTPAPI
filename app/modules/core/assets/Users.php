<?php

namespace App\Modules\Core\Assets;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class Users implements IAsset {

    public function put(UploadedFile $file, $path)
    {
        $id = md5($file->getClientOriginalName() . '-' . $file->getSize() . '-' . $file->getClientMimeType());
        $file->move($path, $id);
        return $id;
    }
}