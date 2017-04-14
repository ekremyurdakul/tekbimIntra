<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Counts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->string('location')->nullable();
            $table->string('notes')->nullable();
            $table->integer('quantity')->nullable();
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('group_id')
                ->references('id')->on('groups');


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
        Schema::dropIfExists('transactions');
    }
}
