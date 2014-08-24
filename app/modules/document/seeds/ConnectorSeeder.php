<?php

namespace App\Modules\Document\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Document\Models\Connector;

class ConnectorSeeder extends Seeder
{

    public function run()
    {

        Connector::create(
            [
                'name' => 'indesign_soap',
                'protocol' => 'App\Modules\Document\Protocol\Indesign\Soap',
                'active' => 1
            ]
        );

        Connector::create(
            [
                'name' => 'indesign_rest',
                'protocol' => 'App\Modules\Document\Protocol\Indesign\Rest',
                'active' => 1
            ]
        );

        Connector::create(
            [
                'name' => 'scribus_rest',
                'protocol' => 'App\Modules\Document\Protocol\Scribus\Rest',
                'active' => 1
            ]
        );
    }
}
