<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StuffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stuffs')->insert([
            [
                'code' => 'asus-56152',
                'id_unit' => 3,
                'id_type' => 1,
                'id_category' => 4,
                'id_supplier' => 19,
                'name' => 'Asus 56152',
                'price' => 15000000,
                'amount' => 3,
                'status_bhp' => 1,
            ],
            [
                'code' => 'nokia',
                'id_unit' => 3,
                'id_type' => 1,
                'id_category' => 3,
                'id_supplier' => 4,
                'name' => 'Nokia',
                'price' => 20000000,
                'amount' => 2,
                'status_bhp' => 1,
            ],
        ]);
    }
}
