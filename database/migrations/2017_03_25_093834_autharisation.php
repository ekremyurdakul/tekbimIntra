<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Autharisation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('authorisation_types', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->timestamps();

        });
        Schema::create('authorisations', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('authorisation_type_id');

            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('module_id')
                ->references('id')->on('modules');
            $table->foreign('authorisation_type_id')
                ->references('id')->on('authorisation_types');

            $table->timestamps();

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('authorisations');
        Schema::dropIfExists('authorisation_types');

    }
}
