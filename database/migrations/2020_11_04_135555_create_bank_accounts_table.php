<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger("financial_organization_id")->length(6);
            $table->bigInteger("store_id")->length(20)->nullable();
            $table->string('account_name',255);
            $table->string('account_no',100)->nullable();
            $table->string('branch',50)->nullable();
            $table->tinyInteger('account_type')->length(1)->nullable();
            $table->string('swift_code',100)->nullable();
            $table->string('route_no',100)->nullable();
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
        Schema::dropIfExists('bank_accounts');
    }
}
