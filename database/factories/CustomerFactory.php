<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['I','B']);
        $name= $type =='I'? fake()->name() : fake()->company();
        return [
           'name' => $name,
           'email' => fake()->unique()->safeEmail(),
           'type' =>  $type,
           'address' => fake()->streetAddress(),
           'city' => fake()->city(),
           'state' => fake()->state(),
           'postal_code' => fake()->postcode(),
        ];
    }
}
