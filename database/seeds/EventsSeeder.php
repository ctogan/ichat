<?php

use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'event_name' => 'anniversary celebration',
            'start_date' => '2022-02-08 00:00:01',
            'end_date' => '2022-02-08 23:59:59',
            'min_transaction' => '100',
            'day_transaction' => '30',
            'created_at'=>date('Y-m-d H:i:s')
        ]);
    }
}
