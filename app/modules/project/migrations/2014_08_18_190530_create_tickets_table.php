<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::dropIfExists('tickets');
			Schema::create(
					'tickets',
					function (Blueprint $table) {
							$table->increments('id');
							$table->unsignedInteger('user_id');
							$table->unsignedInteger('project_id');
							$table->string('name');
							$table->text('description')
									->nullable();
							$table->foreign('user_id')
									->references('id')
									->on('users');
							$table->foreign('project_id')
									->references('id')
									->on('projects');
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
				'tickets',
				function (Blueprint $table) {
						$table->drop();
				}
		);
	}

}
