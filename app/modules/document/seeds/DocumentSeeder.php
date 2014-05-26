<?php

namespace App\Modules\Document\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Document\Models\Document;

class DocumentSeeder extends Seeder
{

    public function run()
    {
        Document::create(
            [
                'company_id' => 1,
                'user_id' => 1,
                'name' => 'sample indd document',
                'description' => 'it\'s just a sample document',
                'file' => 'plop.indd',
                'type' => 1
            ]
        );

        Document::create(
            [
                'company_id' => 1,
                'user_id' => 1,
                'name' => 'sample sla document',
                'description' => 'it\'s just a sample document',
                'file' => 'plop.sla',
                'type' => 2
            ]
        );
    }
} 