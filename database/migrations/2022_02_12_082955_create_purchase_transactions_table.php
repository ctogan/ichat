<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned();
            $table->decimal('total_spent',$precision = 10, $scale = 2);
            $table->decimal('total_saving',$precision = 10, $scale = 2);
            $table->timestamp('transaction_at');
            $table->timestamps();
        });
        Schema::table('purchase_transactions', function($table) {
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_transactions');
    }
}
