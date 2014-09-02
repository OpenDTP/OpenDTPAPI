<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('projects');
        Schema::create(
            'projects',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('company_id');
                $table->string('name');
                $table->datetime('end');
                $table->text('description')
                    ->nullable();
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
                $table->foreign('company_id')
                    ->references('id')
                    ->on('companies');
                $table->foreign('team_id')
                    ->references('id')
                    ->on('teams');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'projects',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }

}
