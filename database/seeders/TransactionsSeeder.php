<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = \Faker\Factory::create('id_ID');
    
            DB::table("transactions")->insert([
                'user_id' => 1,
                'product_id' => 11,
                "status" => 'PENDING',
                "reference_number" => '',
                "quantity" => '2',
                "price" => 1000,
                "total_price" => 2000,
            ]);
        
    }
}
