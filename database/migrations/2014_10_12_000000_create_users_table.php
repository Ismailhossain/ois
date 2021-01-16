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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('agent_id')->unique();
            $table->string('email')->unique();
            $table->char('status')->default(0)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });


        Schema::create('user_property',function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('property_id')->unsigned();
            $table->timestamps();
        });


        Schema::create('properties', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('owner_name');
            $table->string('owner_email');
            $table->string('owner_phone');
            $table->string('slug')->unique();
            $table->string('address')->nullable();
            $table->string('size')->nullable();
            $table->string('floor')->nullable();
            $table->string('bed')->nullable();
            $table->string('price')->nullable();
            $table->tinyInteger('status_id')->unsigned();
            $table->dateTime('signing_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_property');
        Schema::dropIfExists('properties');
    }
}
