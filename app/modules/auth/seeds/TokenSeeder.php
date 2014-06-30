<?php

namespace App\Modules\Auth\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Auth\Models\OAuthClients;
use App\Modules\Auth\Models\OAuthScopes;

class TokenSeeder extends Seeder
{

    public function run()
    {
        // Default OpenDTP app token
        OAuthClients::create(
            [
                'id' => 0,
                'secret' => '',
                'name' => 'opendtp_front'
            ]
        );

        // Default scope
        OAuthScopes::create(
            [
                'id' => 0,
                'scope' => 'default',
                'name' => 'default',
                'description' => 'Default scope, should be replaced with some custom scopes'
            ]
        );
    }
}
