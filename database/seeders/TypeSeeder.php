<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                'name' => 'Elektronik',
                'group' => 'sarana',
            ],
            [
                'name' => 'Plastik',
                'group' => 'sarana',
            ],
            [
                'name' => 'Kayu',
                'group' => 'prasarana',
            ],
            [
                'name' => 'Gedung',
                'group' => 'prasarana',
            ],
            [
                'name' => 'Mobil',
                'group' => 'sarana',
            ],
        ]);
    }
}
