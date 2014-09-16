<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 22/05/14
 * Time: 10:34
 */

namespace App\Modules\Project\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Project\Models\Project;

class ProjectSeeder extends Seeder
{

    public function run()
    {
        // First dummy Project
        Project::create(
            [
                'name' => 'dproject',
                'description' => 'First Dummy project',
                'user_id' => 1,
                'company_id' => 1,
                'team_id' => 1
            ]
        );

        // Second dummy Project
        Project::create(
            [
                'name' => 'dproject2',
                'description' => 'Second Dummy project',
                'user_id' => 1,
                'company_id' => 2
            ]
        );

        // Third dummy Project
        Project::create(
            [
                'name' => 'dproject3',
                'description' => 'Third Dummy project',
                'user_id' => 2,
                'company_id' => 1
            ]
        );
    }
}
