<?php

namespace App\Modules\Storage\Connectors;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Indesign implements IConnector {
    public function store(UploadedFile $file, Document $document) {

    }

    public function delete($id) {}

    public function get($id) {}
} 