<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_purchase AS
                SELECT customer_id,SUM(total_spent) as total_spent
                FROM purchase_transactions
                GROUP BY customer_id;
        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_purchase');
    }
}
