<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{

  /**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::dropIfExists('teams');
			Schema::create(
					'teams',
					function (Blueprint $table) {
							$table->increments('id');
							$table->unsignedInteger('user_id');
							$table->string('name');
							$table->text('description')
									->nullable();
							$table->foreign('user_id')
									->references('id')
									->on('users');
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
				'teams',
				function (Blueprint $table) {
						$table->drop();
				}
		);
	}

}
