<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                UserSeeder::class,
                AdminSeeder::class,
                TypeSeeder::class,
                CategorySeeder::class,
                UnitSeeder::class,
                SupplierSeeder::class,
                StuffSeeder::class,
                LocationSeeder::class,
            ]
        );

    }
}
