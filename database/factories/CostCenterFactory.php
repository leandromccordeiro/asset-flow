<?php

namespace Database\Factories;

use App\Models\CostCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class CostCenterFactory extends Factory
{
    protected $model = CostCenter::class;

    public function definition()
    {
        return [
            'code' => fake()->unique()->numerify('CC###'),
            'description' => fake()->unique()->words(3, true)
        ];
    }
}