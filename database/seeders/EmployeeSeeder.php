<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\CostCenter;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $costCenters = CostCenter::all();

        foreach ($costCenters as $costCenter) {
            Employee::factory()
                ->count(rand(3, 8))
                ->create(['cost_center_id' => $costCenter->id]);
        }
    }
}