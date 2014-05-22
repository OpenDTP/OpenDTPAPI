<?php

namespace App\Modules\Document\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Document\Models\Connector;

class ConnectorSeeder extends Seeder
{

    public function run() {

        Connector::create(
            [
                'name' => 'indesign_soap',
                'active' => 1
            ]
        );

        Connector::create(
            [
                'name' => 'indesign_rest',
                'active' => 1
            ]
        );

        Connector::create(
            [
                'name' => 'scribus_rest',
                'active' => 1
            ]
        );
    }
} 