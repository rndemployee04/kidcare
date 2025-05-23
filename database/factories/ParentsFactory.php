<?php

namespace Database\Factories;

use App\Models\Parents;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parents>
 */
class ParentsFactory extends Factory
{
    protected $model = Parents::class;

    public function definition(): array
    {
        return [
            'user_id' => null, // Set this manually when using the factory
            // Add other fields as needed (example):
            // 'phone' => $this->faker->phoneNumber(),
            // 'address' => $this->faker->address(),
        ];
    }
}
