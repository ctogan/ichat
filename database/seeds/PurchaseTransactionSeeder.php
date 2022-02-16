<?php

use Illuminate\Database\Seeder;

class PurchaseTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purchase_transactions')->insert([
            'customer_id' => '3',
            'total_spent' => '40',
            'total_saving' => '5',
            'transaction_at' => date('Y-m-d H:i:s'),
            'created_at'=>date('Y-m-d H:i:s')
        ]);
    }
}
