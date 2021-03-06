<?php

namespace App\Modules\Core\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Modules\Core\Models\User;

class UserSeeder extends Seeder
{

    public function run()
    {
        // Default admin user
        User::create(
            [
                'login' => 'admin',
                'password' => Hash::make('admin'),
                'email' => 'fake_email@provider.com',
                'firstname' => 'Michael',
                'lastname' => 'FORASTE',
                'description' => 'Fake description of admin'
            ]
        );

        // First dummy user
        User::create(
            [
                'login' => 'duser1',
                'password' => Hash::make('duser1'),
                'email' => 'fake_email_duser1@provider.com',
                'firstname' => 'Gaetan',
                'lastname' => 'GUERAUD',
                'description' => 'Fake description of duser1'
            ]
        );

        // Second dummy user
        User::create(
            [
                'login' => 'duser2',
                'password' => Hash::make('duser2'),
                'email' => 'fake_email_duser2@provider.com'
            ]
        );

        // Third dummy user
        User::create(
            [
                'login' => 'duser3',
                'password' => Hash::make('duser3'),
                'email' => 'fake_email_duser3@provider.com'
            ]
        );

        // Fourth dummy user
        User::create(
            [
                'login' => 'duser4',
                'password' => Hash::make('duser4'),
                'email' => 'fake_email_duser4@provider.com'
            ]
        );

        // Fourth dummy user
        User::create(
            [
                'login' => 'duser5',
                'password' => Hash::make('duser5'),
                'email' => 'fake_email_duser5@provider.com'
            ]
        );

        // Fifth dummy user
        User::create(
            [
                'login' => 'duser6',
                'password' => Hash::make('duser6'),
                'email' => 'fake_email_duser6@provider.com'
            ]
        );
    }
}
