<?php

namespace App\Modules\Document\Seeds;

use Eloquent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('App\Modules\Document\Seeds\ConnectorSeeder');
        $this->call('App\Modules\Document\Seeds\RendererSeeder');
    }
}
