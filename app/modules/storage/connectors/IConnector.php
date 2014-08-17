<?php

namespace App\Modules\Storage\Connectors;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Modules\Document\Models\Document;

interface IConnector {
    public function store(UploadedFile $file);
    public function delete($id);
    public function get($id);
}
