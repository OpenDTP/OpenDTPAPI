<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('assets');
        Schema::create(
            'assets',
            function (Blueprint $table) {
                $table->string('id');
                $table->string('name');
                $table->string('mime');
                $table->primary('id');
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
            'assets',
            function (Blueprint $table) {
                $table->drop();
            }
        );
	}

}
