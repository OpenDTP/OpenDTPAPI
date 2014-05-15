<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateRenderersTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('renderers');
        Schema::Create(
            'renderers',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('company_id');
                $table->unsignedInteger('connector_id');
                $table->foreign('company_id')
                    ->references('id')
                    ->on('companies');
                $table->foreign('connector_id')
                    ->references('id')
                    ->on('connectors');
                $table->string('name');
                $table->string('address');
                $table->unique('name');
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
            'renderers',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }

}
