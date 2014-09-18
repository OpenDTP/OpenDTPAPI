<?php

namespace App\Modules\Project\Seeds;

use App\Modules\Project\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{

    public function run()
    {
        Team::create(
            [
                'user_id' => 1,
                'name' => 'OpenDTP',
                'description' => 'The OpenDTP Team !'
            ]
        );
    }
}
