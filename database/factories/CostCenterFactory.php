<?php

namespace Database\Factories;

use App\Models\CostCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class CostCenterFactory extends Factory
{
    protected $model = CostCenter::class;

    public function definition()
    {
        $description = [
            'Recursos Humanos',
            'Financeiro',
            'Compras',
            'Vendas',
            'Marketing',
            'TI',
            'Logística',
            'Produção',
            'Qualidade',
            'Manutenção'
        ];
        return [
            'code' => fake()->unique()->numerify('CC###'),
            'description' => fake()->unique()->randomElement($description)
        ];
    }
}