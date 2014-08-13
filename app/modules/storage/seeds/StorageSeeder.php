<?php

namespace App\Modules\Storage\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Storage\Models\Store;

class StorageSeeder extends Seeder
{

    public function run()
    {
        Store::create(
            [
                'mime' => 'application/octet-stream',
                'extension' => 'indd',
                'name' => 'InDesign Document',
                'description' => 'InDesign documents from Adobe',
                'connector' => '\App\Modules\Storage\Connectors\Indesign',
                'active' => true
            ]
        );
    }
}
