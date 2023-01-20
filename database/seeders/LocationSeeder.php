<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            [
                'name' => 'Ruang Kepala',
            ],
            [
                'name' => 'Ruang Kelas',
            ],
            [
                'name' => 'Ruang Olahraga',
            ],
            [
                'name' => 'Masjid',
            ],
            [
                'name' => 'Ruang Tata Usaha',
            ],
        ]);
    }
}
