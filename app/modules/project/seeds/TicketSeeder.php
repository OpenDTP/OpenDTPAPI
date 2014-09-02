<?php

namespace App\Modules\Ticket\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Ticket\Models\Ticket;

class TiketSeeder extends Seeder
{

    public function run()
    {
        // First dummy Ticket
        Ticket::create(
            [             
                'ticket_id' => 1,
                'user_id' => 1,
                'project_id' => 1,
                'result' => 'opendtp.jpg',
                'run_num' => 1,
                'version' => 0.1,
                'name' => 'Ticket !',
                'description' => 'First Dummy ticket'
            ]
        );

        // Second dummy Ticket
        Ticket::create(
            [
                'ticket_id' => 2,
                'user_id' => 1,
                'project_id' => 1,
                'result' => 'opendtp.png',
                'run_num' => 1,
                'version' => 0.1,
                'name' => 'Second Ticket',
                'description' => 'Images are nice'
            ]
        );

        // Third dummy Ticket
        Ticket::create(
            [
                'ticket_id' => 1,
                'user_id' => 1,
                'project_id' => 2,
                'result' => 'test.ind',
                'run_num' => 1,
                'version' => 0.1,
                'name' => 'Indesin test',
                'description' => 'Indesign doc making'
            ]
        );
    }
}
