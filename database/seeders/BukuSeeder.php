<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
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
            DB::table("buku")->insert([
                "kode_buku" => $faker->unique()->name,
                "judul" => $faker->name,
                "pengarang" => $faker->name,
                "isbn" => $faker->numberBetween(1000, 1500),
                "tahun" => $faker->numberBetween(2000, 2020),
            ]);
        }
    }
}
