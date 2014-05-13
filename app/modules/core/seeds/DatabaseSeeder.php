<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 11/05/14
 * Time: 20:30
 */

namespace App\Modules\Core\Seeds;

use Eloquent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Modules\Core\Models\User;
use App\Modules\Core\Models\Company;

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

        // Default admin user
        User::create(
            array(
                'login' => 'admin',
                'password' => Hash::make('admin'),
                'email' => 'fake_email@provider.com'
            )
        );

        // First dummy user
        User::create(
            array(
                'login' => 'duser1',
                'password' => Hash::make('duser1'),
                'email' => 'fake_email_duser1@provider.com'
            )
        );

        // Second dummy user
        User::create(
            array(
                'login' => 'duser2',
                'password' => Hash::make('duser2'),
                'email' => 'fake_email_duser2@provider.com'
            )
        );

        // Third dummy user
        User::create(
            array(
                'login' => 'duser3',
                'password' => Hash::make('duser3'),
                'email' => 'fake_email_duser3@provider.com'
            )
        );

        // Fourth dummy user
        User::create(
            array(
                'login' => 'duser4',
                'password' => Hash::make('duser4'),
                'email' => 'fake_email_duser4@provider.com'
            )
        );

        // Firs dummy Company
        Company::create(
            array(
                'name' => 'dcompany1',
                'description' => 'First Dummy company'
            )
        );

        // Second dummy Company
        Company::create(
            array(
                'name' => 'dcompany2',
                'description' => 'Second Dummy company'
            )
        );
    }

}