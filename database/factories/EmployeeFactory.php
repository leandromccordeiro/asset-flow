<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\CostCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'cpf' => $this->faker->numerify('###########'),
            'birth_date' => $this->faker->dateTimeBetween('-50 years', '-18 years'),
            'cost_center_id' => CostCenter::factory()
        ];
    }
}