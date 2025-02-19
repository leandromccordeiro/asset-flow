<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition()
    {
        // Define uma data de atribuição no último ano
        $assignmentDate = $this->faker->dateTimeBetween('-1 year', '-1 day');

        // 30% de chance de ter uma data de devolução
        // Se tiver, será entre a data de atribuição e hoje
        $returnDate = $this->faker->boolean(30) 
            ? $this->faker->dateTimeBetween($assignmentDate, 'now')
            : null;

        return [
            'employee_id' => Employee::factory(),
            'equipment_id' => Equipment::factory(),
            'assignment_date' => $assignmentDate,
            'return_date' => $returnDate
        ];
    }
}