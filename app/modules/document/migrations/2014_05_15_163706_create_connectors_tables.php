<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectorsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('connectors');
        Schema::Create(
            'connectors',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('protocol');
                $table->boolean('active');
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
            'connectors',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }
}
