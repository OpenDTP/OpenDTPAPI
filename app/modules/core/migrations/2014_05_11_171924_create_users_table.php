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
                $table->unsignedInteger('company_id')
                    ->nullable();
                $table->string('login');
                $table->string('password');
                $table->string('email')
                    ->unique();
                $table->string('firstname')
                    ->nullable();
                $table->string('lastname')
                    ->nullable();
                $table->string('description')
                    ->nullable();
                $table->string('remember_token')
                    ->nullable();
                $table->boolean('valid')
                    ->default(true);
                $table->boolean('blocked')
                    ->default(false);
                $table->foreign('company_id')
                    ->references('id')
                    ->on('companies');
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
