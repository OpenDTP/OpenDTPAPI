<?php

namespace App\Modules\Project\Seeds;

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

        $this->call('App\Modules\Project\Seeds\ProjectSeeder');
    }
}
