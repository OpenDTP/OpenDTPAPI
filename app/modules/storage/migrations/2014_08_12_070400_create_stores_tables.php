<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('stores');
        Schema::Create(
            'stores',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('mime');
                $table->string('extension');
                $table->string('name');
                $table->string('description');
                $table->string('connector');
                $table->boolean('active');
                $table->timestamps();
                $table->unique(['mime', 'extension']);
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
            'stores',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }

}
