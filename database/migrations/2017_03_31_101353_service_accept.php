<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServiceAccept extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('operation_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('serialneed');
            $table->timestamps();
        });

        Schema::create('service_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->string('sno');
            $table->unsignedInteger('customer_id');
            $table->string('fault_description');
            $table->string('person')->nullable();
            $table->unsignedInteger('user_id');
            $table->boolean('priority');
            $table->unsignedInteger('service_status_id');
            $table->unsignedInteger('technician_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('technician_id')    
                ->references('id')->on('users');
            $table->foreign('customer_id')
                ->references('id')->on('customers');
            $table->foreign('service_status_id')
                ->references('id')->on('service_statuses');
        });

        Schema::create('service_product_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_product_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('operation_type_id');
            $table->string('sno')->nullable();
            $table->string('operation_description');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('service_product_id')
                ->references('id')->on('service_products');
            $table->foreign('operation_type_id')
                ->references('id')->on('operation_types');
            $table->timestamps();
        });

        Schema::create('service_product_handovers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_product_id');
            $table->unsignedInteger('user_id');
            $table->string('person')->nullable();
            $table->string('notes');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('service_product_id')
                ->references('id')->on('service_products');
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
        Schema::dropIfExists('service_product_details');
        Schema::dropIfExists('service_product_handovers');
        Schema::dropIfExists('service_products');
        Schema::dropIfExists('service_statuses');
        Schema::dropIfExists('operation_types');
    }
}
