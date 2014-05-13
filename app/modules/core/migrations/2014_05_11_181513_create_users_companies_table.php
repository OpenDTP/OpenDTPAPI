<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCompaniesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users_companies',
            function (Blueprint $table) {
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('company_id');
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
                $table->foreign('company_id')
                    ->references('id')
                    ->on('companies');
                $table->primary(
                    array('user_id', 'company_id')
                );
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
            'users_companies',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }

}
