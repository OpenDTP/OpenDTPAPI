<?php

namespace App\Modules\Core\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Core\Models\UserCompany;

class UserCompanySeeder extends Seeder
{

    public function run()
    {

        // First and second user belong to dcompany1
        UserCompany::create(
            [
                'user_id' => '2',
                'company_id' => '1'
            ]
        );

        UserCompany::create(
            [
                'user_id' => '3',
                'company_id' => '1'
            ]
        );

        // Third and fourth user belong to dcompany2
        UserCompany::create(
            [
                'user_id' => '4',
                'company_id' => '2'
            ]
        );

        UserCompany::create(
            [
                'user_id' => '5',
                'company_id' => '2'
            ]
        );

        // Admin user belong to both companies for tests
        UserCompany::create(
            [
                'user_id' => '1',
                'company_id' => '1'
            ]
        );

        UserCompany::create(
            [
                'user_id' => '1',
                'company_id' => '2'
            ]
        );
    }
} 