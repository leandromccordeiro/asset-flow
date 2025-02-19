<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\GadgetModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition()
    {


        return [
            'gadget_model_id' => GadgetModel::factory(),
            'patrimony' => $this->faker->unique()->numerify('PAT#####'),
            'purchase_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'is_available' => $this->faker->boolean(70) // 70% chance of being available
        ];
    }
}