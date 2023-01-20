<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'phone' => $this->faker->e164PhoneNumber(),
            'address' => $this->faker->address(),
            'description' => $this->faker->text($maxNbChars = 200)
        ];
    }
}
