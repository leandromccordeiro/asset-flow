<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class AssignmentSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
    public function run()
    {
        $employees = Employee::all();
        $equipment = Equipment::where('is_available', true)->get();

        foreach ($equipment as $item) {
            if ($this->faker->boolean(70)) { // 70% chance of creating an assignment
                $employee = $employees->random();
                
                Assignment::create([
                    'employee_id' => $employee->id,
                    'equipment_id' => $item->id,
                    'assignment_date' => now()->subDays(rand(1, 180)),
                    'return_date' => $this->faker->boolean(30) ? now()->subDays(rand(1, 30)) : null
                ]);

                if (!$this->faker->boolean(30)) { // 70% chance of equipment being in use
                    $item->update(['is_available' => false]);
                }
            }
        }
    }
}

