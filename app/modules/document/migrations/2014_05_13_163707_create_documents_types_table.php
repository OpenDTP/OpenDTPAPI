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
        Schema::Create(
            'documents_types',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('type');
                $table->string('extension');
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
