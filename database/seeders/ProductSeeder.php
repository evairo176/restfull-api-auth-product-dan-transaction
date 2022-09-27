<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        for($i=0;$i<10;$i++){
            DB::table("product")->insert([
                "name" => $faker->unique()->name,
                "price" => $faker->numberBetween(1000, 150000),
                "stock" => $faker->numberBetween(100, 300),
            ]);
        }
    }
}
