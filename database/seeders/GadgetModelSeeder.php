<?php

namespace Database\Seeders;

use App\Models\GadgetModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GadgetModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GadgetModel::factory()->count(10)->create();
    }
}
