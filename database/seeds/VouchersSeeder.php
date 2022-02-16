<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class VouchersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 100; $i++){
            DB::table('vouchers')->insert([
                'event_id' => '1',
                'voucher_code' => $faker->regexify('[A-Za-z0-9]{20}'),
                'image' => $faker->image,
                'created_at'=>date('Y-m-d H:i:s')
            ]);
        }
    }
}
