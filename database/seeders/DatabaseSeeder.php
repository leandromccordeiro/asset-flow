<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            CostCenterSeeder::class,
            EmployeeSeeder::class,
            EquipmentSeeder::class,
            AssignmentSeeder::class,
            UserSeeder::class,
        ]);
    }
}
