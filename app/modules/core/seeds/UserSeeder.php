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
                'email' => 'fake_email@provider.com'
            ]
        );

        // First dummy user
        User::create(
            [
                'login' => 'duser1',
                'password' => Hash::make('duser1'),
                'email' => 'fake_email_duser1@provider.com'
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
    }
} 