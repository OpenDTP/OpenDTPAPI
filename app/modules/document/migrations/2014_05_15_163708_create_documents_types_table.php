<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('documents_types');
        Schema::Create(
            'documents_types',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('company_id')
                    ->nullable();
                $table->string('type');
                $table->string('extension');
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
            'documents_types',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }
}
