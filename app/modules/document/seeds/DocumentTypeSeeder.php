<?php

namespace App\Modules\Document\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Document\Models\DocumentType;
use App\Modules\Document\Models\DocumentTypeConnector;

class DocumentTypeSeeder extends Seeder
{

    public function run()
    {
        DocumentType::create(
            [
                'name' => 'InDesign Document',
                'extension' => 'indd'
            ]
        );

        DocumentTypeConnector::create(
            [
                'document_type_id' => 1,
                'connector_id' => 1
            ]
        );

        DocumentTypeConnector::create(
            [
                'document_type_id' => 1,
                'connector_id' => 2
            ]
        );

        DocumentType::create(
            [
                'name' => 'Scribus Document',
                'extension' => 'sla'
            ]
        );

        DocumentTypeConnector::create(
            [
                'document_type_id' => 2,
                'connector_id' => 3
            ]
        );
    }
} 