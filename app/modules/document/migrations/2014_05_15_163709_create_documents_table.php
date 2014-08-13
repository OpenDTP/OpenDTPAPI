<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('documents');
        Schema::Create(
            'documents',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('company_id');
                $table->unsignedInteger('user_id');
                $table->string('name');
                $table->string('description')
                    ->nullable();
                $table->string('file');
                $table->string('file_id');
                $table->string('store_id');
                $table->unsignedInteger('type');
                $table->foreign('type')
                    ->references('id')
                    ->on('documents_types');
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
            'documents',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }
}
