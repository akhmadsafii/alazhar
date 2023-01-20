<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;


class AdminFactory extends Factory
{

    protected $model = Admin::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'last_ip' => $this->faker->ipv4(),
            'phone' => $this->faker->phoneNumber(),
            'last_login' => $this->faker->dateTime($max = 'now', $timezone = null),
            'status' => 1,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 12345,
        ];
    }
}
