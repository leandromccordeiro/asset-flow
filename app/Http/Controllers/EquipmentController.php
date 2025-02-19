<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::orderBy('patrimony')->get();
        return view('equipment.index', compact('equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'patrimony' => 'required|string|unique:equipment',
            'purchase_date' => 'required|date',
            'is_available' => 'required|boolean'
        ]);

        Equipment::create($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Equipamento cadastrado com sucesso!');
    }

    public function destroy(Equipment $equipment)
    {
        if ($equipment->assignments()->whereNull('return_date')->exists()) {
            return redirect()->route('equipment.index')
                ->with('error', 'Não é possível excluir um equipamento que está em uso.');
        }

        $equipment->delete();
        return redirect()->route('equipment.index')
            ->with('success', 'Equipamento removido com sucesso!');
    }
}
