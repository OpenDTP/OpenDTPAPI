<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'companies',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->text('description')
                    ->nullable();
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
            'companies',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }

}
