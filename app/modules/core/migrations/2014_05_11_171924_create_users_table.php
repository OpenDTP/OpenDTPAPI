<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('login');
                $table->string('password');
                $table->string('email');
                $table->boolean('valid')
                    ->default(true);
                $table->boolean('blocked')
                    ->default(false);
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
            'users',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }
}
