<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 22/05/14
 * Time: 10:34
 */

namespace App\Modules\Core\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Core\Models\Company;

class CompanySeeder extends Seeder
{

    public function run()
    {
        // Firs dummy Company
        Company::create(
            [
                'name' => 'dcompany1',
                'description' => 'First Dummy company'
            ]
        );

        // Second dummy Company
        Company::create(
            [
                'name' => 'dcompany2',
                'description' => 'Second Dummy company'
            ]
        );

        // third dummy Company
        Company::create(
            [
                'name' => 'dcompany3',
                'description' => 'thrird Dummy company'
            ]
        );
    }
}
