<?php

namespace App\Modules\Document\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Document\Models\Renderer;

class RendererSeeder extends Seeder
{

    public function run() {
        Renderer::create(
            [
                'company_id' => 1,
                'connector_id' => 1,
                'name' => 'InDesign main',
                'address' => '192.168.1.1'
            ]
        );

        Renderer::create(
            [
                'company_id' => 1,
                'connector_id' => 1,
                'name' => 'InDesign fallback',
                'address' => '192.168.1.2'
            ]
        );

        Renderer::create(
            [
                'company_id' => 2,
                'connector_id' => 1,
                'name' => 'Scribus',
                'address' => '192.168.1.3'
            ]
        );
    }
} 