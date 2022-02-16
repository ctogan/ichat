<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReedemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reedems', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            $table->bigInteger('voucher_id');
            $table->string('image')->nullable();
            $table->string('status')->default('process');
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
        Schema::dropIfExists('reedems');
    }
}
