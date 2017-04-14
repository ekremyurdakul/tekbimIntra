<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->timestamps();
        });

        Schema::create('hpeparts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_identifier');
            $table->string('product_description');
            $table->dateTime('stock_date');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('employee_id');
            $table->string('stock_location')->nullable();
            $table->foreign('customer_id')
                ->references('id')->on('customers');
            $table->foreign('employee_id')
                ->references('id')->on('users');

            $table->timestamps();
        });


        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('user_id');
            $table->boolean('isFinished')->default(0);
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('group_id');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('group_id')
                ->references('id')->on('groups');

            $table->timestamps();
        });

        Schema::create('group_session', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('session_id')->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->foreign('session_id')
                ->references('id')->on('sessions');
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
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('group_session');
        Schema::dropIfExists('hpeparts');
        Schema::dropIfExists('sessions');

        Schema::dropIfExists('groups');
        Schema::dropIfExists('users');
        Schema::dropIfExists('customers');

        
    }
}
