<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition()
    {
        $brands = ['Dell', 'HP', 'Lenovo', 'Apple', 'Samsung', 'Asus'];
        $models = ['Laptop', 'Desktop', 'Monitor', 'Tablet', 'Smartphone'];

        return [
            'model' => $this->faker->randomElement($models),
            'brand' => $this->faker->randomElement($brands),
            'patrimony' => $this->faker->unique()->numerify('PAT#####'),
            'purchase_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'is_available' => $this->faker->boolean(70) // 70% chance of being available
        ];
    }
}