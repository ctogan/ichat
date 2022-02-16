<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $gender = $faker->randomElement($array = array('male','female'));
        for($i = 1; $i <= 50; $i++){

            DB::table('customers')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'gender' => $gender,
                'date_of_birth' => $faker->dateTime,
                'contact_number' => $faker->phoneNumber,
                'email' => $faker->email,
                'created_at'=>date('Y-m-d H:i:s')
            ]);
        }
    }
}
