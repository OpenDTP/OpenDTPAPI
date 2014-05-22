<?php

namespace App\Modules\Core\Seeds;

use Eloquent;

class DatabaseSeeder extends \Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('App\Modules\Core\Seeds\UserSeeder');
        $this->call('App\Modules\Core\Seeds\CompanySeeder');
        $this->call('App\Modules\Core\Seeds\UserCompanySeeder');
    }
}
