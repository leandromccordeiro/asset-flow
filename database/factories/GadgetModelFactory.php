<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GadgetModel>
 */
class GadgetModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Laptop', 'Desktop', 'Monitor', 'Tablet', 'Smartphone'];
        $brands = ['Dell', 'HP', 'Lenovo', 'Apple', 'Samsung', 'Asus'];
        $models = ['Inspiron', 'Pavilion', 'ThinkPad', 'MacBook', 'Galaxy', 'Zenfone'];

        return [
            'type' => $this->faker->randomElement($types),
            'model' => $this->faker->randomElement($models),
            'brand' => $this->faker->randomElement($brands),
        ];
    }
}
