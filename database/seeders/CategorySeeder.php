<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id_type' => 5,
                'name' => 'BMW',
                'description' => 'Mobil Dinas',
            ],
            [
                'id_type' => 5,
                'name' => 'Toyota',
                'description' => 'Bekas',
            ],
            [
                'id_type' => 1,
                'name' => 'HP',
                'description' => '-',
            ],
            [
                'id_type' => 1,
                'name' => 'Laptop',
                'description' => '-',
            ],

        ]);
    }
}
