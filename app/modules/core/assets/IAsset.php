<?php

namespace App\Modules\Core\Assets;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface IAsset {
    public function put(UploadedFile $file, $path);
}
