<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTypesConnectorsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('documents_types_connectors');
        Schema::Create(
            'documents_types_connectors',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('document_type_id');
                $table->unsignedInteger('connector_id');
                $table->foreign('connector_id')
                    ->references('id')
                    ->on('connectors');
                $table->foreign('document_type_id')
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
            'documents_types_connectors',
            function (Blueprint $table) {
                $table->drop();
            }
        );
    }

}
