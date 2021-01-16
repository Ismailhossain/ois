<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_organizations', function (Blueprint $table) {
            $table->increments('id')->length(6);
            $table->string('name',150);
            $table->string('short_name',50)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->timestamp("delete_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_organizations');
    }
}
